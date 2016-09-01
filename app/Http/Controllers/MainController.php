<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class MainController extends BaseController
{
    public function index()
    {
        $categories = \App\Category::all();
        return view('index', ['categories' => $categories]);
    }
    
    public function price()
    {
        return view('price');
    }
    
    public function where()
    {
        return view('where');
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function contacts()
    {
        return view('contacts');
    }
}

