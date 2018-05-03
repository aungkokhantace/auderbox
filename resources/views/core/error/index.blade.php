<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/1/2016
 * Time: 10:51 AM
 */
?>

@extends('layouts.master')
@section('title','Error')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Error !</h1>

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">{{$errorMessage}}</h1>
        </div>
    </div>
</div>
@stop

@section('page_script')
@stop