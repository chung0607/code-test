<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    const CATEGORY_ALL = 'all';
    const CATEGORY_MALE = 'male';
    const CATEGORY_FEMALE = 'female';

    const CATEGORIES = [
        self::CATEGORY_MALE,
        self::CATEGORY_FEMALE,
    ];

    public function setCategories(array $categories)
    {
        DB::table('product_category')->where('product_id', $this->id)->delete();
        foreach ($categories as $category) {
            DB::table('product_category')->insert([
                'product_id'    => $this->id,
                'category'      => $category,
            ]);
        }
    }

    public function categories()
    {
        $rows = DB::table('product_category')->where('product_id', $this->id)->get();
        $categories = [];
        foreach ($rows as $row) {
            $categories[] = $row->category;
        }

        return $categories;
    }
}
