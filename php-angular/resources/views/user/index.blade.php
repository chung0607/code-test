@extends('layouts.backend')

@section('page')
<div class="row" ng-controller="UserController">
    <div class="panel panel-default">
        <div class="panel-heading">
            Manage Users
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="/user/create">
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
                    <div ng-show="users.length == 0">
                        <div class="alert alert-warning">No user</div>
                    </div>
                    <div ng-show="users.length > 0" class="panel panel-default" ng-repeat="user in users">
                        <div class="panel-heading"><% user.name %></div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <span><% user.email %></span>
                                </div>
                                <div class="row">
                                    <a href="/user/edit/<% user.id %>">
                                        <button type="button" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            Edit
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-danger" ng-click="deleteUser(user.id)">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        Delete
                                    </button>
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
