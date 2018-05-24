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
    <div class="error-header-space"></div>
    <!-- <h1 class="page-header error-page-text">Error !</h1>

    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header error-page-text">Sorry, the requested page is not found</h2>
        </div>
    </div> -->
    <!-- start 404 template -->
    <div class="wrapper row2">
      <div id="container" class="clear">

        <section id="fof" class="clear">

          <div class="hgroup clear">
            <h1>404</h1>
            <h2>Error !</h2>
          </div>
          <p>For Some Reason The Page You Requested Could Not Be Found On Our Server</p>

        </section>

      </div>
    </div>
    <!-- End 404 template -->
</div>
@stop

@section('page_script')
@stop
