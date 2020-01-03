<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Packagist\Packagist;
use Illuminate\Support\Collection;

class StatsPackagist extends Command
{
    const ROLE_OWNER = 'owner';
    const ROLE_MEMBER = 'member';
    const ROLE_COLLABORATOR = 'collaborator';
    const ROLE_CONTRIBUTOR = 'contributor';

    protected $name = 'stats:packagist';
    protected $description = 'Load packagist statistics.';

    /**
     * @var Collection
     */
    protected $data;

    public function handle()
    {
        $client = new Client();
        $packagist = new Packagist($client);

        $vendors = [
            'gummibeer' => self::ROLE_OWNER,
            'astrotomic' => self::ROLE_OWNER,
            'curlyspoon' => self::ROLE_OWNER,
        ];
        $packageNames = collect([
            'spatie/enum' => self::ROLE_COLLABORATOR,
            'spatie/emoji' => self::ROLE_CONTRIBUTOR,
            'spatie/laravel-activitylog' => self::ROLE_COLLABORATOR,
            'spatie/laravel-enum' => self::ROLE_COLLABORATOR,
            'spatie/schema-org' => self::ROLE_COLLABORATOR,
            'spatie/laravel-csp' => self::ROLE_CONTRIBUTOR,
            'dimsav/laravel-translatable' => self::ROLE_COLLABORATOR,
            'fenos/notifynder' => self::ROLE_COLLABORATOR,
            'absolutehh/dotenv-manipulator' => self::ROLE_CONTRIBUTOR,
        ]);

        foreach ($vendors as $vendor => $role) {
            $vendorPackageNames = collect(Arr::get($packagist->getPackagesByVendor($vendor), 'packageNames', []))->flip()->map(function () use ($role) {
                return $role;
            });

            $packageNames = $packageNames->merge($vendorPackageNames);
        }

        $abandoned = [];
        $packages = collect();
        foreach ($packageNames as $packageName => $role) {
            $package = data_get($packagist->findPackageByName($packageName), 'package');

            if (empty($package)) {
                continue;
            }

            $package['repo_name'] = $package['name'];
            $package['vendor'] = explode('/', $package['name'])[0];
            $package['name'] = explode('/', $package['name'])[1];
            $package['title'] = Str::title(str_replace('-', ' ', $package['name']));
            $package['abandoned'] = $package['abandoned'] ?? null;
            $package['role'] = $role;

            if (! empty($package['abandoned'])) {
                if (! isset($abandoned[$package['abandoned']])) {
                    $abandoned[$package['abandoned']] = [];
                }

                $abandoned[$package['abandoned']][] = $package;
                continue;
            }

            $packages->put($package['repo_name'], $package);
        }

        foreach ($abandoned as $parentName => $abandonedPackages) {
            do {
                $parentPackage = $packages->get($parentName, data_get($packagist->findPackageByName($parentName), 'package'));
                $parentPackage['abandoned'] = $parentPackage['abandoned'] ?? null;
                $parentName = $parentPackage['abandoned'] ?: $parentName;

                if (empty($parentPackage)) {
                    continue 2;
                }
            } while ($parentPackage['abandoned']);

            if (! array_key_exists('repo_name', $parentPackage)) {
                $parentPackage['repo_name'] = $parentPackage['name'];
                $parentPackage['vendor'] = explode('/', $parentPackage['repo_name'])[0];
                $parentPackage['name'] = explode('/', $parentPackage['repo_name'])[1];
                $parentPackage['title'] = title_case(str_replace('-', ' ', $parentPackage['name']));
                $parentPackage['role'] = self::ROLE_CONTRIBUTOR;
            }

            foreach ($abandonedPackages as $abandonedPackage) {
                $parentPackage['downloads']['total'] += $abandonedPackage['downloads']['total'];
                $parentPackage['favers'] += $abandonedPackage['favers'];
            }

            $packages->put($parentName, $parentPackage);
        }

        if ($packages->isNotEmpty()) {
            $this->data = $packages->filter();
            $this->line(sprintf(
                '[<info>packagist</info>] packages: <comment>%d</comment> | downloads: <comment>%d</comment> | favers: <comment>%d</comment>',
                $this->data->count(),
                $this->data->sum('downloads.total'),
                $this->data->sum('favers')
            ));
            $this->line(sprintf(
                '[<info>packagist</info>] abandoned: <comment>%d</comment>',
                count($abandoned)
            ));
            $this->save();
        }
    }

    protected function filePath($file)
    {
        $filepath = storage_path('app/stats/'.$file);
        $filedir = dirname($filepath);
        if (! is_dir($filedir)) {
            mkdir($filedir, 0777, true);
        }

        return $filepath;
    }

    protected function save()
    {
        $this->line('save data to file ...');
        file_put_contents($this->filePath('packagist.json'), $this->data->toJson());
    }
}
