<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SchemaOrg extends Command
{
    protected $name = 'schema-org';
    protected $description = 'Generate schema.org file.';

    public function handle()
    {
        $graph = new \Spatie\SchemaOrg\Graph();

        $graph->country()->name('DE')->alternateName('Germany');
        $graph->postalAddress()
            ->addressCountry($graph->country())
            ->addressRegion('Hamburg')
            ->addressLocality('Hamburg')
            ->postalCode('22307')
            ->streetAddress('Benzenbergweg 3')
        ;
        $graph->person()
            ->name('Tom Witkowski')
            ->givenName('Tom')
            ->familyName('Witkowski')
            ->gender(\Spatie\SchemaOrg\GenderType::Male)
            ->alternateName('Gummibeer')
            ->birthDate(\Carbon\Carbon::create(1993, 1, 25, 17, 0, 0, '+01:00'))
            ->birthPlace(
                \Spatie\SchemaOrg\Schema::place()
                    ->name('Städtisches Klinikum Dresden, Standort Neustadt')
                    ->address(
                        \Spatie\SchemaOrg\Schema::postalAddress()
                            ->addressCountry($graph->country())
                            ->addressRegion('Saxony')
                            ->addressLocality('Dresden')
                            ->postalCode('01129')
                            ->streetAddress('Industriestraße 40')
                    )
                    ->url('https://www.klinikum-dresden.de/Neustadt_Trachau-p-54.html')
            )
            ->url('https://gummibeer.de')
            ->email('dev.gummibeer@gmail.com')
            ->telephone('+491621525105')
            ->jobTitle('PHP Backend Developer')
            ->description('I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.')
            ->homeLocation($graph->postalAddress())
            ->address($graph->postalAddress())
            ->nationality($graph->country())
            ->owns(
                \Spatie\SchemaOrg\Schema::ownershipInfo()
                    ->name('Shootager')
                    ->url('https://shootager.app')
                    ->ownedFrom(\Carbon\Carbon::create(2017, 9, 7, 16, 44, 14, 'UTC'))
            )
            ->sameAs(array_column(social_links(), 'href'))
        ;

        $graph
            ->hide(\Spatie\SchemaOrg\Country::class)
            ->hide(\Spatie\SchemaOrg\PostalAddress::class)
        ;

        file_put_contents(storage_path('app/schema-org.html'), $graph->toScript());
    }
}
