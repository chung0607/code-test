<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        //
        return view('product/index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $query = Product::orderBy('id', 'asc');
        if (in_array($request->category, Product::CATEGORIES)) {
            $rows = DB::table('product_category')->where('category', $request->category)->get();

            $productIds = [];
            foreach ($rows as $row) {
                $productIds[] = $row->product_id;
            }
            $query->whereIn('id', $productIds);
        }
        if (!is_null($request->keyword)) {
            $query->where('name', 'LIKE', "%$request->keyword%");
        }

        $products = $query->get();

        return $products->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product/edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product = $this->_setValues($product, $request);
        $product->save();

        $categories = is_null($request->category) ? [] : $request->category;
        $product->setCategories($categories);

        return redirect()->action('ProductController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $product->categories = $product->categories();
        return view('product/edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product = $this->_setValues($product, $request);
        $product->update();

        $categories = is_null($request->category) ? [] : $request->category;
        $product->setCategories($categories);

        return redirect()->action('ProductController@index');
    }

    private function _setValues(Product $product, Request $request)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->img_url = $request->img_url;

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }

        return ['success' => true];
    }
}
