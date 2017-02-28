@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if (isset($user))
                Edit User
                @else
                Create User
                @endif
            </div>

            <div class="panel-body">
                @if (isset($user))
                <form method="post" action="/user/update/{{$user->id}}">
                    @else
                    <form method="post" action="/user/store">
                        @endif
                        {{ csrf_field() }}
                        <div class="form">
                            <div class="row">
                                <span class="col-sm-4">Name</span>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="user name" type="text" name="name" value="{{isset($user) ? $user->name : ''}}"/>
                                </div>
                            </div>
                            <div class="row">
                                <span class="col-sm-4">Email</span>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" placeholder="aaa@bbb.com" name="email" value="{{isset($user) ? $user->email : ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <span class="col-sm-4">Password</span>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password">
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
