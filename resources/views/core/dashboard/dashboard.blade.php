@extends('layouts.master')
@section('title','Dashboard')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Dashboard</h1>

    <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue"><i class="ion ion-android-person"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Staff</span>
                        <span class="info-box-number">{{ $userCount }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-md-6">
                <div id="chartdiv"></div>
            </div>

            <div class="col-md-6">
                <div id="daily_chart_div"></div>
            </div>

        </div>
</div>
@stop
@section('page_script')
    <script type="text/javascript">
    $(document).ready(function(){
        var chart;
        var chartData =<?php echo json_encode($userCount) ?> ;
        var chart = AmCharts.makeChart( "chartdiv", {
            "theme": "light",
            type: "serial",
            dataProvider: chartData,
            categoryField: "month",
            depth3D: 20,
            angle: 30,

            categoryAxis: {
                labelRotation: 90,
                gridPosition: "start"
            },

            valueAxes: [ {
                title: "Total Amount"
            } ],

            graphs: [ {

                valueField: "total",
                colorField: "color",
                type: "column",
                lineAlpha: 0.1,
                fillAlphas: 1
            } ],

            chartCursor: {
                cursorAlpha: 0,
                zoomable: false,
                categoryBalloonEnabled: false
            },
            export: {
                enabled: true
            }
        } );
    })
    </script>


@endsection
