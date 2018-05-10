@extends('layouts.master')
@section('title','Dashboard')
@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">API List</h1>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#login_api"><b>Login API</b></a></li>
            <li><a data-toggle="tab" href="#retailer_profile_api"><b>Retailer Profile API</b></a></li>
            <li><a data-toggle="tab" href="#retailshop_list_api"><b>Retailshop List Download API</b></a></li>
            <li><a data-toggle="tab" href="#product_list_api"><b>Product List Download API</b></a></li>
            <li><a data-toggle="tab" href="#product_detail_api"><b>Product Detail Download API</b></a></li>
        </ul>

        <div class="tab-content">
            <!-- start login api content -->
            <div id="login_api" class="tab-pane fade in active">
              <h3>URL</h3>
              <p><b>http://localhost:8000/api/login_api</b></p>
              <hr>
              <h3>Request</h3>
              <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "login_info": {
        "phone_no": "09123456789",
        "password": "123@retailer",
        "log_in_at": "2016-10-31 07:24:37"
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "user_id": 4,
  "retailer": {
    "retailer_id": 1,
    "user_id": 4,
    "name_eng": "retailer1",
    "name_mm": "retailer1",
    "nrc": "12\/YAKANA(N)123456",
    "dob": "1990-05-08",
    "phone": "0145798",
    "address": "No(59), Kan Lann, Hlaing, Yangon",
    "photo": "\/images\/retailer_images\/retailer_profile.png"
  },
  "force_password_change": true
}
              </pre>
            </div>
            <!-- end login api content -->

            <!-- start retailer profile api content -->
            <div id="retailer_profile_api" class="tab-pane fade in">
                <h3>URL</h3>
                <p><b>http://localhost:8000/api/retailer_profile</b></p>
                <hr>
                <h3>Request</h3>
                <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "user_profile": {
        "id": 4
      }
    }
  ]
}
                </pre>

                <hr>
                <h3>Response</h3>
                <pre>
{
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "data": [
    {
      "user_profile": {
        "retailer_id": 1,
        "user_id": 4,
        "name_eng": "retailer1",
        "name_mm": "retailer1",
        "nrc": "12\/YAKANA(N)123456",
        "dob": "1990-05-08",
        "phone": "0145798",
        "address": "No(59), Kan Lann, Hlaing, Yangon",
        "photo": "\/images\/retailer_images\/retailer_profile.png"
      }
    }
  ]
}
              </pre>
        </div>
        <!-- end retailer profile api content -->

        <!-- start retailshop list api content -->
        <div id="retailshop_list_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_shop_list</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "retailshops": {
        "retailer_id": 1
      }
    }
  ]
}
            </pre>

            <hr>
            <h3>Response</h3>
            <pre>
{
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "data": [
    {
      "retailshops": [
        {
          "id": 1,
          "retailer_id": 1,
          "name_eng": "Pyae Sone (1)",
          "name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1041)",
          "phone": "0145678",
          "address": "No(59), Kan Lann, Hlaing, Yangon",
          "registration_no": "abc-112233"
        },
        {
          "id": 2,
          "retailer_id": 1,
          "name_eng": "Pyae Sone (2)",
          "name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1042)",
          "phone": "0198752",
          "address": "No(11), In Sein Road, Hlaing, Yangon",
          "registration_no": "abc-445566"
        }
      ]
    }
  ]
}
                </pre>
        </div>
        <!-- end retailshop list api content -->

        <!-- start product list api content -->
        <div id="product_list_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_product_list</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "products": {
        "product_category_id": 1,
        "retailshop_id": 1
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "data": [
  {
    "products": [
      {
        "id": 1,
        "product_category_id": "1",
        "brand_owner_id": "1",
        "name": "Coca Cola 1.5L",
        "image": "/images/product_images/OB_Coca-Cola 1.5L_Dry_LR.jpg",
        "sku": "coca-115",
        "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in history",
        "status": "1",
        "created_by": "1",
        "updated_by": "1",
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": "900.00",
        "minimum_order_qty": 1,
        "maximum_order_qty": 50,
        "out_of_stock_flag": 0
      },
      {
        "id": 3,
        "product_category_id": "1",
        "brand_owner_id": "1",
        "name": "Coca Cola 300ml Bottle",
        "image": "/images/product_images/OB_Coca-Cola 350mL_Dry_LR.jpg",
        "sku": "coca-300b",
        "remark": "Coca Cola 300ml bottle is the most popular and biggest selling soft drink in history",
        "status": "1",
        "created_by": "1",
        "updated_by": "1",
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": "350.00",
        "minimum_order_qty": 1,
        "maximum_order_qty": 50,
        "out_of_stock_flag": 1
      },
      {
        "id": 4,
        "product_category_id": "1",
        "brand_owner_id": "1",
        "name": "Coca Cola 300ml Can",
        "image": "/images/product_images/OB_Coca-Cola_Zero_330mL_Dry_LR.jpg",
        "sku": "coca-300c",
        "remark": "Coca Cola 300ml can is the most popular and biggest selling soft drink in history",
        "status": "1",
        "created_by": "1",
        "updated_by": "1",
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": "300.00",
        "minimum_order_qty": 1,
        "maximum_order_qty": 50,
        "out_of_stock_flag": 0
      },
      {
        "id": 5,
        "product_category_id": "1",
        "brand_owner_id": "1",
        "name": "Max+ C",
        "image": "/images/product_images/Max+C_Frontier_350mL_Dry_LR.jpg",
        "sku": "coca-mc1",
        "remark": "Coca Cola Max+ C is the most popular and biggest selling soft drink in history",
        "status": "1",
        "created_by": "1",
        "updated_by": "1",
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": "300.00",
        "minimum_order_qty": 1,
        "maximum_order_qty": 50,
        "out_of_stock_flag": 0
      }
    ]
  }
]
}
              </pre>
        </div>
        <!-- end product list api content -->

        <!-- start product detail api content -->
        <div id="product_detail_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_product_detail</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "product_detail": {
        "product_id": 1,
        "retailshop_id": 1
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "data": [
    {
      "product_detail": {
        "id": 1,
        "product_category_id": "1",
        "brand_owner_id": "1",
        "name": "Coca Cola 1.5L",
        "image": "/images/product_images/OB_Coca-Cola 1.5L_Dry_LR.jpg",
        "sku": "coca-115",
        "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in history",
        "status": "1",
        "created_by": "1",
        "updated_by": "1",
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": "900.00",
        "minimum_order_qty": 1,
        "maximum_order_qty": 50,
        "out_of_stock_flag": 0
      }
    }
  ]
}
              </pre>
        </div>
        <!-- end product detail api content -->
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
