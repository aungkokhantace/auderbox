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
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Invoice Status</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->status_text}}</h4></div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>Address</h4></div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4>{{$invoice->retailshop_address}}</h4></div>
      </div>
      <br>
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
                        <th colspan="2">Change Status</th>
                        <!-- <th>Change Status</th> -->
                    </tr>
                    </thead>
                    <tfoot>
                    <!-- <tr>
                        <th class="search-col" con-id="no">No.</th>
                        <th class="search-col" con-id="brand_owner">Brand Owner</th>
                        <th class="search-col" con-id="product">Product</th>
                        <th class="search-col" con-id="sku">SKU</th>
                        <th class="search-col" con-id="qty">Qty</th>
                        <th class="search-col" con-id="order_date">Order Date</th>
                        <th class="search-col" con-id="delivery_date">Delivery Date</th>
                        <th class="search-col" con-id="amount">Amount</th>
                        <th class="search-col" con-id="status">Status</th>
                        <th></th>
                        <th></th>
                    </tr> -->
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
                          <td>
                            @if($invoice_detail->status == App\Core\StatusConstance::status_confirm_value)
                              <form id="frm_invoice_partial_cancel_{{$invoice_detail->id}}" method="post" action="/backend/invoice_report/partial_cancel_invoice">
                                  {{ csrf_field() }}
                                  <input type="hidden" id="partial_canceled_invoice_detail_id" name="partial_canceled_invoice_detail_id" value="{{$invoice_detail->id}}">
                                  <button type="button" onclick="partial_cancel_invoice('{{$invoice_detail->id}}');" class="btn btn-danger">
                                      CANCEL
                                  </button>
                              </form>
                            @endif
                          </td>
                          <td>
                            @if($invoice_detail->status == App\Core\StatusConstance::status_confirm_value)
                              <!-- <form id="frm_change_qty_{{$invoice_detail->id}}" method="post" action="/backend/invoice_report/partial_deliver_invoice">
                                  {{ csrf_field() }}
                                  <input type="hidden" id="partial_delivered_invoice_detail_id" name="partial_delivered_invoice_detail_id" value="{{$invoice_detail->id}}">
                                  <button type="button" onclick="partial_deliver_invoice('{{$invoice_detail->id}}');" class="btn btn-success">
                                      Change Quantity
                                  </button>
                              </form> -->
                              @if($invoice_detail->quantity > 0)
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_{{$invoice_detail->id}}">Change Quantity</button>
                              @endif
                              <!-- start modal -->
                              <div class="modal fade" id="myModal_{{$invoice_detail->id}}" role="dialog">
                                <div class="modal-dialog">

                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Partial Invoice Cancellation (Change order quantity)</h4>
                                    </div>

                                    <!-- Start Modal Body -->
                                    <div class="modal-body">
                                        <form id="frm_change_qty_{{$invoice_detail->id}}" method="post" action="/backend/invoice_report/detail/change_quantity">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="quantity_change_invoice_detail_id" name="quantity_change_invoice_detail_id" value="{{$invoice_detail->id}}">
                                            <div class="row">
                                              <div class="col-md-3">
                                                Ordered Quantity
                                              </div>

                                              <div class="col-md-1"> : </div>

                                              <div class="col-md-4">
                                                {{$invoice_detail->quantity}}
                                              </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                              <div class="col-md-3">
                                                New Quantity
                                              </div>

                                              <div class="col-md-1"> : </div>

                                              <div class="col-md-4">
                                                <select class="form-control" id="new_qty" name="new_qty">
                                                  <!-- if upper limit to show is greater than $max_order_qty, just show up to $max_order_qty -->
                                                  @if((ceil(($invoice_detail->quantity) / 100)) * 100) < $max_order_qty)
                                                    <!-- nearest hundred of (qty+100) -->
                                                    @for($i = (ceil(($invoice_detail->quantity) / 100)) * 100; $i >= 0 ; $i--)
                                                      @if($i == 0)
                                                        <option value="{{$i}}">{{$i}} (Cancel)</option>
                                                      @elseif($i == $invoice_detail->quantity)
                                                        <option value="{{$i}}" selected>{{$i}}</option>
                                                      @else
                                                        <option value="{{$i}}">{{$i}}</option>
                                                      @endif
                                                    @endfor
                                                  @else
                                                    @for($i = $max_order_qty; $i >= 0 ; $i--)
                                                      @if($i == 0)
                                                        <option value="{{$i}}">{{$i}} (Cancel)</option>
                                                      @elseif($i == $max_order_qty)
                                                        <option value="{{$i}}" selected>{{$i}}</option>
                                                      @else
                                                        <option value="{{$i}}">{{$i}}</option>
                                                      @endif
                                                    @endfor
                                                  @endif
                                                </select>
                                              </div>
                                              <div class="col-md-4">
                                                <button type="button" onclick="change_invoice_detail_quantity('{{$invoice_detail->id}}');" class="btn btn-danger">
                                                    Change Quantity
                                                </button>
                                              </div>
                                            </div>
                                            <br>
                                        </form>
                                    </div>
                                    <!-- End Modal Body -->

                                    <!-- <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div> -->
                                  </div>

                                </div>
                              </div>
                              <!-- end modal -->
                            @endif
                          </td>
                      </tr>
                      <?php $number_count++; ?>
                      @endforeach

                      <!-- start invoice promotion -->
                      @foreach($promo_product_array as $promo_product_detail)
                      <tr>
                          <td>{{$number_count}}</td>
                          <td>{{$promo_product_detail->brand_owner_name}}</td>
                          <td>{{$promo_product_detail->name}}</td>
                          <td>{{$promo_product_detail->sku}}</td>
                          <td>{{$promo_product_detail->quantity}}</td>
                          <td>{{$invoice->order_date}}</td>
                          <td>{{$invoice->delivery_date}}</td>
                          <td>{{number_format($promo_product_detail->payable_amt,2)}}</td>
                          <td>{{$promo_product_detail->status_text}}</td>
                          <td></td>
                          <td></td>
                      <tr>
                      <?php $number_count++; ?>
                      @endforeach
                      <!-- end invoice promotion -->
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
      // $('#list-table tfoot th.search-col').each( function () {
      //     var title = $('#list-table thead th').eq( $(this).index() ).text();
      //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
      // } );

      // var table = $('#list-table').DataTable({
      //     aLengthMenu: [
      //         [10,15,25, 50, 100, 200, -1],
      //         [10,15,25, 50, 100, 200, "All"]
      //     ],
      //     iDisplayLength: 5,
      //     // "order": [[ 1, "desc" ]],
      //     stateSave: false,
      //     "pagingType": "full",
      //     "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',
      //     "pageLength": 15
      // });

      // Apply the search
      // table.columns().eq( 0 ).each( function ( colIdx ) {
      //     $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
      //         table
      //                 .column( colIdx )
      //                 .search( this.value )
      //                 .draw();
      //     } );
      //
      // });
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
