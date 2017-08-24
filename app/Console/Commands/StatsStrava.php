<?php
namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class StatsStrava extends Command
{
    protected $name = 'stats:strava';
    protected $description = 'Load strava statistics.';

    /**
     * @var Collection
     */
    protected $data;

    public function handle()
    {
        $url = 'https://www.strava.com/api/v3/athletes/'.getenv('STRAVA_ID').'/stats';

        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer '.getenv('STRAVA_TOKEN'),
            ],
        ]);
        if($response->getStatusCode() == 200) {
            $this->data = new Collection(json_decode($response->getBody()->__toString(), true)['all_ride_totals']);
            $this->line(sprintf(
                '[<info>%s</info>] count: <comment>%d</comment> | distance: <comment>%d</comment> | elevation: <comment>%d</comment> | time: <comment>%d</comment>',
                getenv('STRAVA_ID'),
                $this->data->get('count'),
                $this->data->get('distance'),
                $this->data->get('elevation_gain'),
                $this->data->get('moving_time')
            ));
            $this->save();
        }
    }

    protected function filePath($file)
    {
        $filepath =  storage_path('app/stats/'.$file);
        $filedir = dirname($filepath);
        if(!is_dir($filedir)) {
            mkdir($filedir, 0777, true);
        }
        return $filepath;
    }

    protected function save()
    {
        $this->line('save data to file ...');
        file_put_contents($this->filePath('strava.json'), $this->data->toJson());
        file_put_contents($this->filePath('ride_distance.txt'), intval($this->data->get('distance') / 1000 ));
        file_put_contents($this->filePath('ride_elevation.txt'), intval($this->data->get('elevation_gain')));
        file_put_contents($this->filePath('ride_time.txt'), intval($this->data->get('moving_time') / 60 / 60));
    }
}
