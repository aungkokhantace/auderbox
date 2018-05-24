<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/1/2016
 * Time: 10:51 AM
 */
?>

@extends('layouts.master')
@section('title','Page Not Found')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Error !</h1>

    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Sorry, the requested page is not found</h2>
            <p>
                <b>File => </b> {{$e->getFile()}}<br><br>
                <b>Line => </b> {{$e->getLine()}}<br><br>
                <b>Message => </b> {{$e->getMessage()}}<br><br>
                <b>Exception => </b> {{$e->getPrevious()}}<br><br>
                {{$e->getTraceAsString()}}
            </p>
        </div>
    </div>
</div>
@stop

@section('page_script')
@stop
