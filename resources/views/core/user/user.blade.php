@extends('layouts.master')
@section('title','User')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        @if(isset($profile))
            Update Profile
        @else
            {{ isset($user) ?  'Staff Edit' : 'Staff Entry' }}
        @endif
    </h1>

    {{--check new or edit--}}
    @if(isset($user))
        {!! Form::open(array('url' => '/backend/user/update', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/user/store', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($user)? $user->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="user_name">Staff Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Staff Login User Name" value="{{ isset($user)? $user->user_name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('user_name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="display_name">Display Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="display_name" name="display_name" placeholder="Enter Staff Display Name" value="{{ isset($user)? $user->staff_id:Request::old('display_name') }}"/>
            <p class="text-danger">{{$errors->first('display_name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="email">Email<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="email" class="form-control" id="email" name="email" placeholder="Enter Staff Email" value="{{ isset($user)? $user->email:Request::old('email') }}"/>
            <p class="text-danger">{{$errors->first('email')}}</p>
        </div>
    </div>

    @if(!isset($user))
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="discount">Password<span class="require">*</span></label>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input required type="password" class="form-control" id="password" name="password" placeholder="Enter Password"/>
                <p class="text-danger">{{$errors->first('password')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="discount">Confirm Password<span class="require">*</span></label>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input required type="password" class="form-control" id="password" name="conpassword" placeholder="Enter Confirm Password"/>
                <p class="text-danger">{{$errors->first('conpassword')}}</p>
            </div>
        </div>
    @endif

    @if(isset($profile))
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="discount">Password<span class="require">*</span></label>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"/>
                <p class="text-danger">{{$errors->first('password')}}</p>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="discount">Staff Role<span class="require">*</span></label>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($user))
                <select class="form-control" name="role_id" id="role_id">
                    @foreach($roles as $role)
                        @if($role->id == $user->role_id)
                            <option value="{{$user->role_id}}" selected>{{$user->role->name}}</option>
                        @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                    @endforeach
                </select>
            @else
                <select class="form-control" name="role_id" id="role_id">
                    <option value="" selected disabled>Select Staff Role</option>

                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            @endif
            <p class="text-danger">{{$errors->first('role_id')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="address">Address</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
             <textarea rows="4" cols="50"class="form-control" id="address" name="address" placeholder="Enter Staff Address">{{ isset($user)? $user->address:Request::old('address') }}</textarea>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($user)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('user')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
@stop