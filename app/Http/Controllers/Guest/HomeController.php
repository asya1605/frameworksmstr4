<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        return view('guest.home', compact('menus'));
    }
}