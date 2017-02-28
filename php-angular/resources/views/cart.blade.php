@extends('layouts.app')

@section('content')
<div class="container" ng-controller="CartController">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/">
                        <button class="btn btn-default col-xs-12">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                            Back
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

        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Shopping Cart
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div ng-show="cartItems.length == 0">
                                    <div class="alert alert-warning">No item in cart</div>
                                </div>
                                <div ng-show="cartItems.length > 0" class="panel panel-default" ng-repeat="cartItem in cartItems">
                                    <div class="panel-heading"><% cartItem.product.name %></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="Quantity" name="quantity" value="<%cartItem.quantity%>"/>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="updateQuantity(cartItem.id, $index)">
                                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                                            Update Quantity
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span>$<% cartItem.product.price %></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span><% cartItem.product.description %></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="thumbnail">
                                                    <img ng-src="<% cartItem.product.img_url %>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-8">

                                                <button type="button" class="btn btn-danger" ng-click="deleteCartItem(cartItem.id)">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                    Delete
                                                </button>
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