<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Country;
use Illuminate\Console\Command;
use Spatie\SchemaOrg\GenderType;
use Spatie\SchemaOrg\PostalAddress;

class SchemaOrg extends Command
{
    protected $name = 'schema-org';
    protected $description = 'Generate schema.org file.';

    public function handle()
    {
        $graph = new Graph();

        /** @var StatsGithub $statsGithub */
        $statsGithub = app(StatsGithub::class);
        $response = $statsGithub->request('repos/Gummibeer/cv-resume');
        $graph->website()
            ->url(url('/'))
            ->name(title())
            ->provider($graph->person())
            ->creator($graph->person())
            ->accountablePerson($graph->person())
            ->about($graph->person())
            ->mainEntity($graph->person())
            ->copyrightHolder($graph->person())
            ->copyrightYear(2015)
            ->dateCreated(Carbon::parse($response['created_at']))
            ->datePublished(Carbon::parse($response['created_at']))
            ->dateModified(Carbon::parse($response['updated_at']))
            ->accessMode([
                'textual',
                'visual',
            ])
            ->accessModeSufficient('textual')
            ->inLanguage(Schema::language()->name('English')->alternateName('en'))
            ->isAccessibleForFree(true)
            ->license('https://github.com/Gummibeer/cv-resume/blob/master/LICENSE');

        $graph->country()->name('DE')->alternateName('Germany');
        $graph->postalAddress()
            ->addressCountry($graph->country())
            ->addressRegion('Hamburg')
            ->addressLocality('Hamburg')
            ->postalCode('22307')
            ->streetAddress('Benzenbergweg 3');
        $graph->person()
            ->name('Tom Witkowski')
            ->givenName('Tom')
            ->familyName('Witkowski')
            ->gender(GenderType::Male)
            ->alternateName('Gummibeer')
            ->birthDate(Carbon::create(1993, 1, 25, 0, 0, 0, '+01:00'))
            ->birthPlace(
                Schema::place()
                    ->name('Dresden')
                    ->address(
                        Schema::postalAddress()
                            ->addressCountry($graph->country())
                            ->addressRegion('Saxony')
                            ->addressLocality('Dresden')
                    )
            )
            ->url(url('/'))
            ->email('dev@gummibeer.de')
            ->telephone('+491621525105')
            ->jobTitle('PHP Backend Developer')
            ->description('I\'m an enthusiastic web developer and free time gamer from Hamburg, Germany.')
            ->homeLocation($graph->postalAddress())
            ->address($graph->postalAddress())
            ->nationality($graph->country())
            ->owns(
                Schema::ownershipInfo()
                    ->name('Shootager')
                    ->url('https://shootager.app')
                    ->ownedFrom(Carbon::create(2017, 9, 7, 16, 44, 14, 'UTC'))
            )
            ->sameAs(array_column(social_links(), 'href'))
            ->parents([
                Schema::person()
                    ->name('Sylvia Witkowski')
                    ->givenName('Sylvia')
                    ->familyName('Witkowski')
                    ->gender(GenderType::Female)
                    ->birthDate(Carbon::create(1972, 6, 29, 0, 0, 0, '+02:00'))
                    ->nationality($graph->country()),
                Schema::person()
                    ->name('Kay Franke')
                    ->givenName('Kay')
                    ->familyName('Franke')
                    ->gender(GenderType::Male)
                    ->nationality($graph->country()),
            ])
            ->memberOf(
                Schema::organization()
                    ->name('EVEN ON SUNDAY')
                    ->legalName('EVEN ON SUNDAY GmbH')
                    ->address(
                        Schema::postalAddress()
                            ->addressCountry($graph->country())
                            ->addressRegion('Lower Saxony')
                            ->addressLocality('Osnabrück')
                            ->postalCode('49080')
                            ->streetAddress('Heinrichstraße 14c')
                    )
                    ->url('https://www.even-on-sunday.com')
                    ->telephone('+4954198268610')
                    ->email('hello@even-on-sunday.com')
                    ->vatID('DE298290088')
                    ->founders([
                        Schema::person()
                            ->name('Janek Feldmann')
                            ->givenName('Janek')
                            ->familyName('Feldmann')
                            ->jobTitle('Managing Partner')
                            ->email('jfe@even-on-sunday.com'),
                        Schema::person()
                            ->name('David Pérez González')
                            ->givenName('David')
                            ->additionalName('Pérez')
                            ->familyName('González')
                            ->jobTitle('Managing Partner')
                            ->email('dpg@even-on-sunday.com'),
                    ])
                ->employees([
                    Schema::person()
                        ->name('Carola Born')
                        ->givenName('Carola')
                        ->familyName('Born')
                        ->jobTitle('Chief Creative Officer')
                        ->email('cbo@even-on-sunday.com'),
                    Schema::person()
                        ->name('Ina Offermann')
                        ->givenName('Ina')
                        ->familyName('Offermann')
                        ->jobTitle('Chief Product Officer')
                        ->email('iof@even-on-sunday.com'),
                    Schema::person()
                        ->name('Benedikt Spellmeyer')
                        ->givenName('Benedikt')
                        ->familyName('Spellmeyer')
                        ->jobTitle('Head of Development')
                        ->email('bsp@even-on-sunday.com'),
                ])
            );

        $graph
            ->hide(Country::class)
            ->hide(PostalAddress::class);

        file_put_contents(storage_path('app/schema-org.json'), json_encode($graph->toArray()));
    }
}
