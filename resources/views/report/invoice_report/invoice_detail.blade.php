@extends('layouts.master')
@section('title','Invoice Details')
@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <div class="row">
      <div class="col-md-10">
        <h1 class="page-header">Invoice Details</h1>
      </div>
      <div class="col-md-2">
        <button type="button" class="form-control btn-danger btn-in-header" onclick="redirect_to_invoice_report();"><i class="fa fa-angle-double-left"></i> Back to invoice list</button>
      </div>
    </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Invoice Number</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->id}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Retailer Name</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->retailer_name_eng}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Retailer Phone</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->retailer_phone}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Retailshop Name</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->retailshop_name_eng}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Total Amount</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{number_format($invoice->total_payable_amt,2)}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Address</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->retailshop_address}}</h4></div>
      </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table list-table" id="list-table">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Brand Owner</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="no">No.</th>
                        <th class="search-col" con-id="brand_owner">Brand Owner</th>
                        <th class="search-col" con-id="product">Product</th>
                        <th class="search-col" con-id="sku">SKU</th>
                        <th class="search-col" con-id="qty">Qty</th>
                        <th class="search-col" con-id="order_date">Order Date</th>
                        <th class="search-col" con-id="delivery_date">Delivery Date</th>
                        <th class="search-col" con-id="amount">Amount</th>
                        <th class="search-col" con-id="status">Status</th>
                    </tr>
                    </tfoot>
                    <tbody>
                      <?php $number_count = 1;?>
                      @foreach($invoice->invoice_details as $invoice_detail)
                      <tr>
                          <td>{{$number_count}}</td>
                          <td>{{$invoice_detail->brand_owner_name}}</td>
                          <td>{{$invoice_detail->product_name}}</td>
                          <td>{{$invoice_detail->sku}}</td>
                          <td>{{$invoice_detail->quantity}}</td>
                          <td>{{$invoice->order_date}}</td>
                          <td>{{$invoice->delivery_date}}</td>
                          <td>{{number_format($invoice_detail->payable_amt,2)}}</td>
                          <td>{{$invoice_detail->status_text}}</td>
                      </tr>
                      <?php $number_count++; ?>
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
