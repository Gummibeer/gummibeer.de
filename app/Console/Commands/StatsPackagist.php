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
            'dimsav/laravel-translatable',
            'fenos/notifynder',
            'absolutehh/dotenv-manipulator',
        ]);

        foreach($vendors as $vendor) {
            try {
                $packageNames = $packageNames->merge(array_get($packagist->getPackagesByVendor($vendor), 'packageNames', []));
            } catch (\Exception $ex) {}
        }

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

            $packages->push($package);
        }

        if ($packages->isNotEmpty()) {
            $this->data = $packages->filter();
            $this->line(sprintf(
                '[<info>packagist</info>] packages: <comment>%d</comment> | downloads: <comment>%d</comment>',
                $this->data->count(),
                $this->data->sum('downloads.total')
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
