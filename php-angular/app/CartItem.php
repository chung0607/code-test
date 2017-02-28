<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function product()
    {
        return Product::where('id', $this->product_id)->first();
    }
}
