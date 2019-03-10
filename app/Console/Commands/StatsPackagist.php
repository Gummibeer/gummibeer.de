<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Packagist\Packagist;

class StatsPackagist extends Command
{
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
            'gummibeer',
            'astrotomic',
            'curlyspoon',
        ];
        $packageNames = collect([
            'spatie/laravel-activitylog',
            'spatie/schema-org',
            'dimsav/laravel-translatable',
            'fenos/notifynder',
            'absolutehh/dotenv-manipulator',
        ]);

        foreach($vendors as $vendor) {
            $packageNames = $packageNames->merge(array_get($packagist->getPackagesByVendor($vendor), 'packageNames', []));
        }

        $abandoned = [];
        $packages = collect();
        foreach($packageNames->unique() as $packageName) {
            $package = data_get($packagist->findPackageByName($packageName), 'package');

            if(empty($package)) {
                continue;
            }

            $package['repo_name'] = $package['name'];
            $package['vendor'] = explode('/', $package['name'])[0];
            $package['name'] = explode('/', $package['name'])[1];
            $package['title'] = title_case(str_replace('-', ' ', $package['name']));

            if(!empty($package['abandoned'])) {
                if(!isset($abandoned[$package['abandoned']])) {
                    $abandoned[$package['abandoned']] = [];
                }

                $abandoned[$package['abandoned']][] = $package;
                continue;
            }

            $packages->put($package['repo_name'], $package);
        }

        foreach($abandoned as $parentName => $abandonedPackages) {
            $parentPackage = $packages->get($parentName, data_get($packagist->findPackageByName($parentName), 'package'));
            if(empty($parentPackage)) {
                continue;
            }

            foreach($abandonedPackages as $abandonedPackage) {
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
        $filepath = storage_path('app/stats/' . $file);
        $filedir = dirname($filepath);
        if (!is_dir($filedir)) {
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
