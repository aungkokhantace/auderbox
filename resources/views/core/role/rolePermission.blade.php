@extends('layouts.master')
@section('title','Role Permission')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Role Listing</h1>
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Role's Details</strong></h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        <tr> <td>Role's Name</td><td>{{$role->name}}</td> </tr>
                        <tr> <td>Role's Description</td><td>{{$role->descr}}</td> </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--Start Accordion-->
            <div class="panel-group" id="accordion">
                @foreach ($features_permissions as $feature_permission)

                    <div class="panel panel-inverse">
                        <!-- Panel Heading -->
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#feature_{{$feature_permission['feature']['module']}}">
                                    <i class="fa fa-plus-circle pull-right"></i>
                                    {{$feature_permission['feature']['module']}}
                                </a>
                            </h3>
                        </div>
                        <!-- End Panel Heading -->

                        <!-- Start Panel Body -->
                        <div id="feature_{{$feature_permission['feature']['module']}}" class="panel-collapse collapse">
                            <div class="panel-body">

                                {!! Form::open(array('url' => 'backend/rolePermissionAssign/'.$role->id, 'method'=>'POST','class'=> 'form-horizontal user-form-border', 'data-parsley-validate'=>'true')) !!}

                                <table class="footable table toggle-circle metro-black demo" data-filter-minimum="2">

                                    <tbody>
                                    @foreach($feature_permission['permissions'] as $permission)
                                        <tr>
                                            @if($permission['checked'])
                                                <td>{{$permission['name']}} - {{$permission['descr']}}</td>
                                                <td>
                                                    <input type="hidden" name="permission_{{$permission['id']}}" value="off">
                                                    <input name="permission_{{$permission['id']}}" type="checkbox" data-render="switchery" data-theme="default" checked /></td>
                                            @else
                                                <td>{{$permission['name']}} - {{$permission['descr']}}</td>
                                                <td>
                                                    <input type="hidden" name="permission_{{$permission['id']}}" value="off">
                                                    <input name="permission_{{$permission['id']}}" type="checkbox" data-render="switchery" data-theme="default" /></td>
                                            @endif
                                            <input type="hidden" name="module" id="module" value="{{$feature_permission['feature']['module']}}">

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-success pull-right">Apply</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <!-- End Panel Body -->
                    </div>

                @endforeach
            </div>
            <!--End Accordion-->
        </div>
        <!-- end of col-md-6-->

    </div>

</div>
@stop

@section('page_script') @parent
<script>
    $(document).ready(function() {
        renderSwitcher();
        checkSwitcherState();
    });
</script>
@stop