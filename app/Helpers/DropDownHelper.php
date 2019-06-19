<?php

if (!function_exists('__itemDropdown')) {
    function __itemDropdown()
    {
        $items = \App\Model\Item::pluck('title', 'id');
        return ($items ? $items->toArray() : []);
    }
}

if (!function_exists('__itemCategoryDropdown')) {
    function __itemCategoryDropdown()
    {
        $itemcategories = \App\Model\ItemCategory::pluck('name', 'id');
        return ($itemcategories ? $itemcategories->toArray() : []);
    }
}

if (!function_exists('__customerDropdown')) {
    function __customerDropdown()
    {
        $customers = \App\Model\Customer::selectRaw("CONCAT(name,' - ',mobile_no) as name, id")->pluck('name', 'id');
        return ($customers ? $customers->toArray() : []);
    }
}
