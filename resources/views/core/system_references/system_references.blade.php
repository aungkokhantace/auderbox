@extends('layouts.master')
@section('title','System References')
@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">System References</h1>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#invoice_status_constances"><b>Invoice Status Constances</b></a></li>
            <li><a data-toggle="tab" href="#item_level_promotion_types"><b>Item Level Promotion Types</b></a></li>
        </ul>

        <div class="tab-content">
            <!-- start invoice_status_constances content -->
            <div id="invoice_status_constances" class="tab-pane fade in active">
              <h3>Invoice Status Constances</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>Ordered</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Delivered</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>Canceled (Auderbox)</td>
                        <td>4</td>
                    </tr>
                </table>
            </div>
            <!-- end invoice_status_constances content -->

            <!-- start item_level_promotion_types content -->
            <div id="item_level_promotion_types" class="tab-pane fade in">
              <h3>Item Level Promotion Types</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>Quantity Promotion</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Amount Promotion</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Percentage Promotion</td>
                        <td>3</td>
                    </tr>
                </table>
            </div>
            <!-- end item_level_promotion_types content -->
      </div>
    </div>
</div>
@stop
@section('page_script')
    <script type="text/javascript">
    $(document).ready(function(){

    })
    </script>


@endsection
