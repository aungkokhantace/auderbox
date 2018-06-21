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
            <li><a data-toggle="tab" href="#retailer_points"><b>Retailer Points</b></a></li>
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

            <!-- start retailer points content -->
            <div id="retailer_points" class="tab-pane fade in">
              <h3>"promotion_points" table</h3>
              <p>"with_expiration" flag's default value is 0,<br>
if with_expiration flag is 1, system will calculate
the point expiry date by the point_life_time_day_count</p>

              <hr>
              <h3>"retailer_point_log" table status</h3>
              <table border="2" width="300px" style="text-align: center">
                  <tr>
                      <td><strong>Name</strong></td>
                      <td><strong>Value</strong></td>
                  </tr>
                  <tr>
                      <td>Deliver [+]</td>
                      <td>1</td>
                  </tr>
                  <tr>
                      <td>Reward Claim [-]</td>
                      <td>2</td>
                  </tr>
              </table>
              <br>
              <p>Remark : </p>
              <p>If (status == 1),<br>
                there will not be data at "retailer_reward_id ) and retailer_reward_id = NULL
              <br>
              If (status == 2),<br>
              there will be data at "retailer_reward_id )
              </p>
              <hr>
            </div>
            <!-- end retailer points content -->
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
