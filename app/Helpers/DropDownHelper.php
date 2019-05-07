<?php

if (!function_exists('__itemDropdown')) {
    function __itemDropdown()
    {
        $items = \App\Model\Item::pluck('title', 'id');
        return ($items ? $items->toArray() : []);
    }
}
