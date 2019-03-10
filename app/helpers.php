<?php

if (! function_exists('asset')) {
    function asset($path)
    {
        return url($path.'?v='.file_get_contents(base_path('.version')));
    }
}

if (! function_exists('title')) {
    function title($title = '')
    {
        return implode(' | ', array_filter([trim($title), 'Tom Witkowski']));
    }
}

if (! function_exists('selected_countries')) {
    function selected_countries()
    {
        $allCountries = require resource_path('all_countries.php');
        $selected = json_decode(file_get_contents(resource_path('selected_countries.json')), true);
        $countries = array_intersect_key($allCountries, array_combine($selected, $selected));
        ksort($countries);

        return $countries;
    }
}

if (! function_exists('social_links')) {
    function social_links()
    {
        return require resource_path('sociallinks.php');
    }
}
