@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/">
                        <button class="btn btn-default col-xs-12">
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                            Frontend
                        </button>
                    </a>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Menu</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/products">Products</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/users">Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            @yield('page')
        </div>
    </div>
</div>
@endsection
