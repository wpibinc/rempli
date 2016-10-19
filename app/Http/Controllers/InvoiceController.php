<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InvoiceController extends Controller
{
    public function over8kg(Request $request)
    {
        header('Content-Type: text/html; charset=utf-8');
        echo "<pre>";
        var_dump('123');
        echo "</pre>";
        die();
    }
}
