<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 7/30/2019
 * Time: 8:11 PM
 */

namespace App\Http\ViewComposers;


use App\Model\DisplaySettings;
use Illuminate\View\View;

class DisplayComposer
{

    public function compose(View $view)
    {
        $display_settings = DisplaySettings::first();
         $view->with('display_settings',$display_settings);
    }
}