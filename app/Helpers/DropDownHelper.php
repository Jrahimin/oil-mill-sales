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

if (!function_exists('__userDropdown')) {
    function __userDropdown()
    {
        $customers = \App\User::selectRaw("CONCAT(name,' - ',mobile_no) as name, id")->pluck('name', 'id');
        return ($customers ? $customers->toArray() : []);
    }
}

if (!function_exists('__itemUnitDropdown')) {
    function __itemUnitDropdown()
    {
        $itemUnits = \App\Model\ItemUnit::pluck('name', 'id');
        return ($itemUnits ? $itemUnits->toArray() : []);
    }
}

if (!function_exists('__vehiclesDropdown')) {
    function __vehiclesDropdown()
    {
        $vehicles = \App\Model\Vehicle::pluck('title', 'id');
        return ($vehicles ? $vehicles->toArray() : []);
    }
}

if (!function_exists('__routesDropdown')) {
    function __routesDropdown()
    {
        $routes = \App\Model\Route::selectRaw("CONCAT(journey_from,' : ',journey_to) as route, id")->pluck('route', 'id');
        return ($routes ? $routes->toArray() : []);
    }
}
