<?php


namespace App\ViewComposers;


use App\Models\City;
use Illuminate\View\View;

class CitiesComposer
{
    public function compose(View $view){
        $cities = City::all()->sortBy('city');
        $view->with('cities', $cities);
    }
}
