<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function VirtualOffice()
    {

        return redirect()->route('DispenseDrugs');

    }

}