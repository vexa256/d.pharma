<?php

namespace App\Http\Controllers;

#use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function NotiFicationsCloud(Type $var = null)
    {
        $data = [

            "Page" => "stats.Notifications",
            "Title" => "System Notifications Dashboard",
            "Desc" => "Statistics and Notifications Panel",
            //"Drugs" => $Drugs,

        ];

        return view('scrn', $data);
    }
}