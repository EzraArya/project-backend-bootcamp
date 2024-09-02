<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    function index(){
        $items = Item::all();

        return View::make('welcome')
            ->with('items', $items);
    }
}
