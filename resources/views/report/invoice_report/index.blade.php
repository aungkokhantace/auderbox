@extends('layouts.master')
@section('title','Invoice Report')
@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">Invoice Report</h1>
    <div class="row">
      <!-- start from date -->
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
          <label for="from_date" class="text_bold_black">From Date</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
              <input type="text" class="form-control" id="from_date" name="from_date" value="{{isset($from_date)? $from_date : ''}}">
              <div class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </div>
          </div>
          <p class="text-danger">{{$errors->first('from_date')}}</p>
      </div>
      <!-- end from date -->

      <!-- start to date -->
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
          <label for="to_date" class="text_bold_black">To Date</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <div class="input-group date dateTimePicker" data-provide="datepicker"  id="datepicker_to">
              <input type="text" class="form-control" id="to_date" name="date" value="{{isset($to_date)? $to_date : ''}}">
              <div class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </div>
          </div>
          <p class="text-danger">{{$errors->first('to_date')}}</p>
      </div>
      <!-- end to date -->

      <!-- start status -->
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
          <label for="to_date" class="text_bold_black">Status</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <select class="form-control" id="status" name="status">
          @if(isset($status))
          <option value="all">All</option>
          <option value="{{App\Core\StatusConstance::status_pending_value}}" @if($status == App\Core\StatusConstance::status_pending_value) selected @endif> {{App\Core\StatusConstance::status_pending_description}}</option>
          <option value="{{App\Core\StatusConstance::status_confirm_value}}" @if($status == App\Core\StatusConstance::status_confirm_value) selected @endif>{{App\Core\StatusConstance::status_confirm_description}}</option>
          <option value="{{App\Core\StatusConstance::status_deliver_value}}" @if($status == App\Core\StatusConstance::status_deliver_value) selected @endif>{{App\Core\StatusConstance::status_deliver_description}}</option>
          <option value="{{App\Core\StatusConstance::status_retailer_cancel_value}}" @if($status == App\Core\StatusConstance::status_retailer_cancel_value) selected @endif>{{App\Core\StatusConstance::status_retailer_cancel_description}}</option>
          <option value="{{App\Core\StatusConstance::status_brand_owner_cancel_value}}" @if($status == App\Core\StatusConstance::status_brand_owner_cancel_value) selected @endif>{{App\Core\StatusConstance::status_brand_owner_cancel_description}}</option>
          <option value="{{App\Core\StatusConstance::status_auderbox_cancel_value}}" @if($status == App\Core\StatusConstance::status_auderbox_cancel_value) selected @endif>{{App\Core\StatusConstance::status_auderbox_cancel_description}}</option>
          @else
          <option value="all">All</option>
          <option value="{{App\Core\StatusConstance::status_pending_value}}">{{App\Core\StatusConstance::status_pending_description}}</option>
          <option value="{{App\Core\StatusConstance::status_confirm_value}}">{{App\Core\StatusConstance::status_confirm_description}}</option>
          <option value="{{App\Core\StatusConstance::status_deliver_value}}">{{App\Core\StatusConstance::status_deliver_description}}</option>
          <option value="{{App\Core\StatusConstance::status_retailer_cancel_value}}">{{App\Core\StatusConstance::status_retailer_cancel_description}}</option>
          <option value="{{App\Core\StatusConstance::status_brand_owner_cancel_value}}">{{App\Core\StatusConstance::status_brand_owner_cancel_description}}</option>
          <option value="{{App\Core\StatusConstance::status_auderbox_cancel_value}}">{{App\Core\StatusConstance::status_auderbox_cancel_description}}</option>
          @endif
        </select>
      </div>
      <!-- end status -->

      <!-- start search button -->
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <button type="button" onclick="report_search_by_date_and_status('invoice_report')" class="form-control btn-danger">Search</button>
      </div>
      <!-- end search button -->
    </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table list-table" id="list-table">
                    <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Retailshop Name (Eng)</th>
                        <th>Invoice Date</th>
                        <th>Delivered Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="invoice_number">Invoice Number</th>
                        <th class="search-col" con-id="retailshop_name_eng">Retailshop Name (Eng)</th>
                        <th class="search-col" con-id="invoice_date">Invoice Date</th>
                        <th class="search-col" con-id="delivered_date">Delivered Date</th>
                        <th class="search-col" con-id="status">Status</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td><a href="/backend/invoice_report/detail/{{$invoice->id}}">{{$invoice->id}}</a></td>
                            <td>{{$invoice->retailshop_name_eng}}</td>
                            <td>{{$invoice->order_date}}</td>
                            <td>{{$invoice->delivery_date}}</td>
                            <td>{{$invoice->status_text}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('page_script')
    <script type="text/javascript">
    $(document).ready(function(){
      //start data table
      $('#list-table tfoot th.search-col').each( function () {
          var title = $('#list-table thead th').eq( $(this).index() ).text();
          $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
      } );

      var table = $('#list-table').DataTable({
          aLengthMenu: [
              [10,15,25, 50, 100, 200, -1],
              [10,15,25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 5,
          // "order": [[ 1, "desc" ]],
          stateSave: false,
          "pagingType": "full",
          "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',
          "pageLength": 15
      });

      // Apply the search
      table.columns().eq( 0 ).each( function ( colIdx ) {
          $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
              table
                      .column( colIdx )
                      .search( this.value )
                      .draw();
          } );

      });
      //end datatable

      //start datepickers
      $('#datepicker_from').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          allowInputToggle: true,
      });

      $('#datepicker_to').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          allowInputToggle: true,

      });
      //end datepickers
    })
    </script>


@endsection
