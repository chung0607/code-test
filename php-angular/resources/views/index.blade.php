@extends('layouts.app')

@section('content')
<div class="container" ng-controller="IndexController" ng-init="init('{{$category}}')">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/cart">
                        <button class="btn btn-default col-xs-12">
                            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                            Shopping Cart
                        </button>
                    </a>
                    <a href="/products">
                        <button class="btn btn-default col-xs-12">
                            <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                            Backend
                        </button>
                    </a>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Category</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/?category={{App\Product::CATEGORY_ALL}}">All</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/?category={{App\Product::CATEGORY_MALE}}">Male</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/?category={{App\Product::CATEGORY_FEMALE}}">Female</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Products
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search something" name="keyword"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="search()">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                Search
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div ng-show="products.length == 0">
                                    <div class="alert alert-warning">No product</div>
                                </div>
                                <div ng-show="products.length > 0" class="panel panel-default" ng-repeat="product in products track by $index">
                                    <div class="panel-heading"><% product.name %></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span>$<% product.price %></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span><% product.description %></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="thumbnail">
                                                    <img ng-src="<% product.img_url %>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="Quantity" name="quantity"/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-success" ng-click="addToCart(product.id, $index)">
                                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                                Add to Cart
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection