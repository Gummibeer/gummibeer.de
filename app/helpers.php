<?php
if(!function_exists('asset')) {
    function asset($path) {
        return url($path.'?v='.file_get_contents(base_path('.version')));
    }
}