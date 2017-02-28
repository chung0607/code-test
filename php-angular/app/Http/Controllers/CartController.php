<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return view('cart');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $cartItems = CartItem::where('user_token', $request->session()->all()['_token'])->get();
        foreach ($cartItems as &$item) {
            $item->product = $item->product();
        }

        return $cartItems->toJson();
    }

    public function add(Request $request)
    {
        $cartItem = new CartItem();
        $cartItem->product_id = $request->product_id;
        $cartItem->quantity = $request->quantity;
        $cartItem->user_token = $request->session()->all()['_token'];
        $cartItem->save();

        return ['success' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
        }

        return ['success' => true];
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
        $cartItem = CartItem::find($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->update();

        return ['success' => true];
    }
}
