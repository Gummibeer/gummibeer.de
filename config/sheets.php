<?php

use App\Job;
use App\Post;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\ContentParsers\YamlParser;
use Spatie\Sheets\PathParsers\SlugParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

return [
    'default_collection' => 'static',

    'collections' => [
        'static',
        'posts' => [
            'disk' => 'posts',
            'sheet_class' => Post::class,
            'path_parser' => SlugWithDateParser::class,
            'content_parser' => MarkdownWithFrontMatterParser::class,
            'extension' => 'md',
        ],
        'jobs' => [
            'disk' => 'jobs',
            'sheet_class' => Job::class,
            'path_parser' => SlugParser::class,
            'content_parser' => YamlParser::class,
            'extension' => 'yml',
        ],
    ],
];
