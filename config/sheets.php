<?php

use App\Post;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
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
    ],
];
