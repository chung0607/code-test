@extends('layouts.backend')

@section('page')
<div class="row" ng-controller="ProjectController" xmlns="http://www.w3.org/1999/html">
    <div class="panel panel-default">
        <div class="panel-heading">
            Manage Products
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="/product/create">
                                <button type="button" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    Add
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div ng-show="products.length == 0">
                        <div class="alert alert-warning">No product</div>
                    </div>
                    <div ng-show="products.length > 0" class="panel panel-default" ng-repeat="product in products">
                        <div class="panel-heading"><% product.name %></div>
                        <div class="panel-body">
                            <div class="col-sm-8">
                                <div class="row">
                                    <span>$<% product.price %></span>
                                </div>
                                <div class="row">
                                    <span><% product.description %></span>
                                </div>
                                <div class="row">
                                    <a href="/product/edit/<% product.id %>">
                                        <button type="button" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            Edit
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-danger" ng-click="deleteProduct(product.id)">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="thumbnail">
                                    <img ng-src="<% product.img_url %>"/>
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
