<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $category = in_array($request->category, Product::CATEGORIES) ? $request->category : 'all';
        $data = [
            'category'  => $category,
        ];
        return view('index', $data);
    }

}
