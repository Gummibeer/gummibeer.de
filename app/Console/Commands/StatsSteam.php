<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class StatsSteam extends Command
{
    protected $name = 'stats:steam';
    protected $description = 'Load steam statistics.';

    /**
     * @var Collection
     */
    protected $data;

    public function handle()
    {
        $url = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/';
        $query = http_build_query([
            'key' => getenv('STEAM_KEY'),
            'steamid' => getenv('STEAM_ID'),
            'format' => 'json',
        ]);

        $client = new Client();
        $response = $client->request('GET', $url.'?'.$query);
        if ($response->getStatusCode() == 200) {
            $this->data = new Collection(json_decode($response->getBody()->__toString(), true)['response']['games']);
            $this->line(sprintf(
                '[<info>%s</info>] games: <comment>%d</comment> with total playtime: <comment>%d</comment>',
                getenv('STEAM_ID'),
                $this->data->count(),
                round($this->data->sum('playtime_forever') / 60)
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
        file_put_contents($this->filePath('steam.json'), $this->data->toJson());
        file_put_contents($this->filePath('games.txt'), $this->data->count());
        file_put_contents($this->filePath('playtime.txt'), round($this->data->sum('playtime_forever') / 60));
    }
}
