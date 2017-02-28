@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if (isset($product))
                Edit Product
                @else
                Create Product
                @endif
            </div>

            <div class="panel-body">
                @if (isset($product))
                <form method="post" action="/product/update/{{$product->id}}">
                @else
                    <form method="post" action="/product/store">
                @endif
                    {{csrf_field()}}
                    <div class="form">
                        <div class="row">
                            <span class="col-sm-4">Name</span>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="product name" type="text" name="name" value="{{isset($product) ? $product->name : ''}}"/>
                            </div>
                        </div>
                        <div class="row">
                            <span class="col-sm-4">Description</span>
                            <div class="col-sm-8">
                                <textarea class="form-control" type="text" name="description">{{isset($product) ? $product->description : ''}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <span class="col-sm-4">Price</span>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" class="form-control" name="price" value="{{isset($product) ? $product->price : ''}}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <span class="col-sm-4">Image URL</span>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="img_url" value="{{isset($product) ? $product->img_url : ''}}" />
                            </div>
                        </div>
                        <div class="row">
                            <span class="col-sm-4">Category</span>
                            <div class="col-sm-8">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        @foreach (App\Product::CATEGORIES as $category)
                                        <div class="row col-xs-12">
                                            <input type="checkbox" name="category[]" value="{{$category}}"
                                                   {{isset($product) && in_array($category, $product->categories) ? 'checked="checked"' : ''}}
                                            /> {{ucfirst($category)}}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                                    Save
                                </button>
                                <a href="/products">
                                    <button type="button" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                                        Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
