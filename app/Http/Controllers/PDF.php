<?php


namespace App\Http\Controllers;


class PDF
{

    public static function loadView($layout, $vars){
        return [$layout, $vars];
}

}