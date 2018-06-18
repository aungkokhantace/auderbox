@extends('layouts.master')
@section('title','API Formats')
@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">API List</h1>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#login_api"><b>Login</b></a></li>
            <li><a data-toggle="tab" href="#retailer_profile_api"><b>Retailer Profile</b></a></li>
            <li><a data-toggle="tab" href="#retailshop_list_api"><b>Retailshop List</b></a></li>
            <li><a data-toggle="tab" href="#product_list_api"><b>Product List</b></a></li>
            <li><a data-toggle="tab" href="#product_detail_api"><b>Product Detail</b></a></li>
            <li><a data-toggle="tab" href="#delivery_date_api"><b>Delivery Date</b></a></li>
            <li><a data-toggle="tab" href="#invoice_upload_api"><b>Invoice Upload</b></a></li>
            <li><a data-toggle="tab" href="#invoice_list_download_api"><b>Invoice List</b></a></li>
            <li><a data-toggle="tab" href="#invoice_detail_download_api"><b>Invoice Detail</b></a></li>
            <li><a data-toggle="tab" href="#add_to_cart_api"><b>Add To Cart</b></a></li>
            <li><a data-toggle="tab" href="#update_cart_qty_api"><b>Update Cart Qty</b></a></li>
            <li><a data-toggle="tab" href="#download_cart_list_api"><b>Download Cart List</b></a></li>
            <li><a data-toggle="tab" href="#download_order_list_api"><b>Download Order List</b></a></li>
            <li><a data-toggle="tab" href="#clear_cart_list_api"><b>Clear Cart List</b></a></li>
            <li><a data-toggle="tab" href="#checkout_cart_api"><b>Checkout Cart</b></a></li>
            <li><a data-toggle="tab" href="#download_item_level_promotion_api"><b>Download Item Level Promotions</b></a></li>
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
  "force_password_change": true,
  "cart_item_count": 5
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
        },
        {
          "id": 3,
          "retailer_id": 1,
          "name_eng": "Pyae Sone (3)",
          "name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1043)",
          "phone": "0198752",
          "address": "No(11), In Sein Road, Hlaing, Yangon",
          "registration_no": "abc-445566"
        },
        {
          "id": 4,
          "retailer_id": 1,
          "name_eng": "Pyae Sone (4)",
          "name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1044)",
          "phone": "0198752",
          "address": "No(11), In Sein Road, Hlaing, Yangon",
          "registration_no": "abc-445566"
        },
        {
          "id": 5,
          "retailer_id": 1,
          "name_eng": "Pyae Sone (5)",
          "name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1045)",
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
            <h4>With Brand Owner Filter</h4>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "products": {
        "product_category_id": 1,
        "retailshop_id": 1,
        "brand_owner_id": 1
      }
    }
  ]
}
              </pre>
              <hr>
              <h4>Without Brand Owner Filter</h4>
              <pre>
  {
    "site_activation_key": "1234567",
    "data": [
      {
        "products": {
          "product_category_id": 1,
          "retailshop_id": 1,
          "brand_owner_id": 0
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
                    "product_group_id": 1,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Coca Cola (250 ml) x 24.png",
                    "sku": "COCA-COLA-000001",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Coca-Cola",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "250 ml\r\n",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 2,
                    "product_group_id": 2,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Coca Cola (330 ml) x 24.png",
                    "sku": "COCA-COLA-000002",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Coca-Cola",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 6,
                    "product_group_id": 6,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Coca Cola Zero (330 ml) x 24.png",
                    "sku": "COCA-COLA-000006",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Coca-Cola Zero",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 8,
                    "product_group_id": 8,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Sprite (330 ml) x 24.png",
                    "sku": "COCA-COLA-000008",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Sprite",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 2,
                    "product_line_name": "Sprite",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 9,
                    "product_group_id": 9,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Sprite (250 ml) x 24.png",
                    "sku": "COCA-COLA-000009",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Sprite",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "250 ml\r\n",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 2,
                    "product_line_name": "Sprite",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 11,
                    "product_group_id": 11,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Max + C (330 ml) x 24.png",
                    "sku": "COCA-COLA-000011",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Max+ C",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 24,
                    "product_group_id": 24,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Max + Orange (330 ml) x 24.png",
                    "sku": "COCA-COLA-000024",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Max+ Orange",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 28,
                    "product_group_id": 28,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Coca Cola (250 ml) x 24.png",
                    "sku": "COCA-COLA-000028",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Fanta Orange",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 4,
                    "product_line_name": "Fanta",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 29,
                    "product_group_id": 29,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Coca Cola (250 ml) x 24.png",
                    "sku": "COCA-COLA-000029",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Fanta Fruit Punch",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 4,
                    "product_line_name": "Fanta",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 30,
                    "product_group_id": 30,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Aquarius (330 ml) x 24.png",
                    "sku": "COCA-COLA-000030",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Aquarius",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 5,
                    "product_line_name": "Aquarius",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 31,
                    "product_group_id": 31,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Burn Energy Drink (250 ml) x 24.png",
                    "sku": "COCA-COLA-000031",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Burn Energy Drink",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "250 ml\r\n",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 6,
                    "product_line_name": "Burn",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 32,
                    "product_group_id": 32,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Schweppes Dry Ginger Ale (330 ml) x 24.png",
                    "sku": "COCA-COLA-000032",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Schweppes Dry Ginger Ale",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 7,
                    "product_line_name": "Schweppes",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 33,
                    "product_group_id": 33,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Schweppes Soda Water (330 ml) x 24.png",
                    "sku": "COCA-COLA-000033",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Schweppes Soda Water",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 7,
                    "product_line_name": "Schweppes",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 34,
                    "product_group_id": 34,
                    "product_uom_type_id": 1,
                    "image": "/images/product_images/Schweppes Tonic Water (330 ml) x 24.png",
                    "sku": "COCA-COLA-000034",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 7200,
                    "name": "Schweppes Tonic Water",
                    "product_uom_type_name_eng": "24 cans/ case",
                    "product_uom_type_name_mm": "24 cans/ case",
                    "product_volume_type_name": "330 ml",
                    "product_container_type_name": "can",
                    "total_uom_quantity": 24,
                    "product_line_id": 7,
                    "product_line_name": "Schweppes",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 4,
                    "product_group_id": 4,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Coca Cola (350 ml) x 12.png",
                    "sku": "COCA-COLA-000004",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Coca-Cola",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 5,
                    "product_group_id": 5,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Coca Cola (600 ml) x 12.png",
                    "sku": "COCA-COLA-000005",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 6000,
                    "name": "Coca-Cola",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 12,
                    "product_group_id": 12,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max + C (350 ml) x 12.png",
                    "sku": "COCA-COLA-000012",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ C",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 13,
                    "product_group_id": 13,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max + C (600 ml) x 12.png",
                    "sku": "COCA-COLA-000013",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 6000,
                    "name": "Max+ C",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 14,
                    "product_group_id": 14,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Power Fruit x 12.png",
                    "sku": "COCA-COLA-000014",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max Power Fruit",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 15,
                    "product_group_id": 15,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Power Fruit-Strawberry x 12.png",
                    "sku": "COCA-COLA-000015",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max Power Strawberry",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 16,
                    "product_group_id": 16,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Cream Soda (350 ml) x 12.png",
                    "sku": "COCA-COLA-000016",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ Cream Soda",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 17,
                    "product_group_id": 17,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Cream Soda (600 ml) x 12.png",
                    "sku": "COCA-COLA-000017",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ Cream Soda",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 18,
                    "product_group_id": 18,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Lime (350 ml) x 12.png",
                    "sku": "COCA-COLA-000018",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ Lime",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 19,
                    "product_group_id": 19,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Lime (600 ml) x 12.png",
                    "sku": "COCA-COLA-000019",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 6000,
                    "name": "Max+ Lime",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 21,
                    "product_group_id": 21,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Lychee (350 ml) x 12.jpg",
                    "sku": "COCA-COLA-000021",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ Lychee",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 22,
                    "product_group_id": 22,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max Lychee (600 ml) x 12.png",
                    "sku": "COCA-COLA-000022",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 6000,
                    "name": "Max+ Lychee",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 25,
                    "product_group_id": 25,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max + Orange (350 ml) x 12.png",
                    "sku": "COCA-COLA-000025",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 3600,
                    "name": "Max+ Orange",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "350 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 26,
                    "product_group_id": 26,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max + Orange (600 ml) x 12.png",
                    "sku": "COCA-COLA-000026",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 6000,
                    "name": "Max+ Orange",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "600 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 36,
                    "product_group_id": 36,
                    "product_uom_type_id": 2,
                    "image": "/images/product_images/Max2O Pure Drinking Water (550 ml) x 12.png",
                    "sku": "COCA-COLA-000036",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 2400,
                    "name": "Max2O Pure Drinking Water",
                    "product_uom_type_name_eng": "12 bottles/ case",
                    "product_uom_type_name_mm": "12 bottles/ case",
                    "product_volume_type_name": "550 ml\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 12,
                    "product_line_id": 8,
                    "product_line_name": "Max2O",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 3,
                    "product_group_id": 3,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Coca Cola (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000003",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Coca-Cola",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 7,
                    "product_group_id": 7,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Coca Cola Zero (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000007",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Coca-Cola Zero",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 1,
                    "product_line_name": "Coca-Cola",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
                },
                {
                    "id": 10,
                    "product_group_id": 10,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Sprite (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000010",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Sprite",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 2,
                    "product_line_name": "Sprite",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 20,
                    "product_group_id": 20,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Max Lime (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000020",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Max+ Lime",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 23,
                    "product_group_id": 23,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Max Lychee (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000023",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Max+ Lychee",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 27,
                    "product_group_id": 27,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Max + Orange (1.5 L) x 6.png",
                    "sku": "COCA-COLA-000027",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 4800,
                    "name": "Max+ Orange",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1.5 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 3,
                    "product_line_name": "Max",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
                },
                {
                    "id": 35,
                    "product_group_id": 35,
                    "product_uom_type_id": 3,
                    "image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png",
                    "sku": "COCA-COLA-000035",
                    "remark": "A product of Coca-Cola Family",
                    "status": 1,
                    "created_by": 1,
                    "updated_by": 1,
                    "deleted_by": null,
                    "created_at": null,
                    "updated_at": null,
                    "deleted_at": null,
                    "price": 1800,
                    "name": "Max2O Pure Drinking Water",
                    "product_uom_type_name_eng": "6 bottles/ case",
                    "product_uom_type_name_mm": "6 bottles/ case",
                    "product_volume_type_name": "1 L\r\n",
                    "product_container_type_name": "bottle",
                    "total_uom_quantity": 6,
                    "product_line_id": 8,
                    "product_line_name": "Max2O",
                    "minimum_order_qty": 1,
                    "maximum_order_qty": 50,
                    "out_of_stock_flag": 0,
                    "promotion_image": null
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
                "product_group_id": 1,
                "product_uom_type_id": 1,
                "image": "/images/product_images/Coca Cola (250 ml) x 24.png",
                "sku": "COCA-COLA-000001",
                "remark": "A product of Coca-Cola Family",
                "status": 1,
                "created_by": 1,
                "updated_by": 1,
                "deleted_by": null,
                "created_at": null,
                "updated_at": null,
                "deleted_at": null,
                "price": 7200,
                "name": "Coca-Cola",
                "product_uom_type_name_eng": "24 cans/ case",
                "product_uom_type_name_mm": "24 cans/ case",
                "product_volume_type_name": "250 ml\r\n",
                "product_container_type_name": "can",
                "total_uom_quantity": 24,
                "product_line_id": 1,
                "product_line_name": "Coca-Cola",
                "minimum_order_qty": 1,
                "maximum_order_qty": 50,
                "out_of_stock_flag": 0,
                "promotion_image": "/images/product_images/Max2O Pure Drinking Water (1 L) x 6.png"
            }
        }
    ]
}
              </pre>
        </div>
        <!-- end product detail api content -->

        <!-- start delivery date api content -->
        <div id="delivery_date_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_delivery_date</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "delivery_date": {
        "brand_owner_id": 1,
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
  "data": "2018-05-15"
}
              </pre>
        </div>
        <!-- end delivery date api content -->

        <!-- start invoice upload api content -->
        <div id="invoice_upload_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/upload_invoice</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "invoices": [
        {
          "id": "INV20180522000001",
          "status": 1,
          "order_date": "2018-05-16",
          "delivery_date": "2018-05-18",
          "payment_date": "2018-05-18",
          "retailer_id": 1,
          "brand_owner_id": 1,
          "retailshop_id": 1,
          "tax_rate": 10,
          "total_net_amt": 5000,
          "total_discount_amt": 500,
          "total_net_amt_w_disc": 4500,
          "total_tax_amt": 450,
          "total_payable_amt": 4950,
          "remark": "invoice remark",
          "confirm_by": 1,
          "confirm_date": "2018-05-16",
          "cancel_by": "",
          "cancel_date": "",
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": "",
          "created_at": "2018-05-16 13:25:03",
          "updated_at": "2018-05-16 13:25:03",
          "deleted_at": "",
          "invoice_detail": [
            {
              "id": "INV20180522000001001",
              "invoice_id": "INV20180522000001",
              "product_id": 1,
              "product_group_id": 1,
              "status": 1,
              "uom_id": 1,
              "uom": "pack",
              "quantity": 6,
              "unit_price": 350,
              "net_amt": 2000,
              "discount_amt": 250,
              "net_amt_w_disc": 1750,
              "tax_amt": 175,
              "payable_amt": 1925,
              "confirm_by": 1,
              "confirm_date": "2018-05-16",
              "cancel_by": "",
              "cancel_date": "",
              "remark": "test test",
              "created_by": 1,
              "updated_by": 1,
              "deleted_by": "",
              "created_at": "2018-05-16 13:25:03",
              "updated_at": "2018-05-16 13:25:03",
              "deleted_at": ""
            },
            {
              "id": "INV20180522000001002",
              "invoice_id": 1,
              "product_id": 2,
              "product_group_id": 1,
              "status": 1,
              "uom_id": 1,
              "uom": "pack",
              "quantity": 6,
              "unit_price": 350,
              "net_amt": 2000,
              "discount_amt": 250,
              "net_amt_w_disc": 1750,
              "tax_amt": 175,
              "payable_amt": 1925,
              "confirm_by": 1,
              "confirm_date": "2018-05-16",
              "cancel_by": "",
              "cancel_date": "",
              "remark": "test test",
              "created_by": 1,
              "updated_by": 1,
              "deleted_by": "",
              "created_at": "2018-05-16 13:25:03",
              "updated_at": "2018-05-16 13:25:03",
              "deleted_at": ""
            }
          ]
        }
      ]
    }
  ]
}
            </pre>

            <hr>
            <h3>Response</h3>
            <pre>
{
  "data": [

  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "invoice_id": "INV20180528000012"
}
            </pre>
        </div>
        <!-- end invoice upload api content -->

        <!-- start invoice list download api content -->
        <div id="invoice_list_download_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_invoice_list</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "invoice_list": {
        "retailer_id": 1,
        "filter": 0
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "data": [
    {
      "id": "INV20180521000001",
      "status": 2,
      "order_date": "2018-05-16 00:00:00",
      "delivery_date": "2018-05-18 00:00:00",
      "payment_date": "2018-05-18 00:00:00",
      "retailer_id": 1,
      "brand_owner_id": 1,
      "retailshop_id": 1,
      "tax_rate": 10,
      "total_net_amt": 5000,
      "total_discount_amt": 500,
      "total_net_amt_w_disc": 4500,
      "total_tax_amt": 450,
      "total_payable_amt": 4950,
      "remark": "invoice remark",
      "confirm_by": null,
      "confirm_date": null,
      "cancel_by": null,
      "cancel_date": null,
      "created_by": 1,
      "updated_by": 1,
      "deleted_by": null,
      "created_at": "2018-05-16 13:25:03",
      "updated_at": "2018-05-16 13:25:03",
      "deleted_at": null,
      "status_text": "Confirmed"
    },
    {
      "id": "INV20180521000002",
      "status": 2,
      "order_date": "2018-05-16 00:00:00",
      "delivery_date": "2018-05-18 00:00:00",
      "payment_date": "2018-05-18 00:00:00",
      "retailer_id": 1,
      "brand_owner_id": 1,
      "retailshop_id": 1,
      "tax_rate": 10,
      "total_net_amt": 5000,
      "total_discount_amt": 500,
      "total_net_amt_w_disc": 4500,
      "total_tax_amt": 450,
      "total_payable_amt": 4950,
      "remark": "invoice remark",
      "confirm_by": null,
      "confirm_date": null,
      "cancel_by": null,
      "cancel_date": null,
      "created_by": 1,
      "updated_by": 1,
      "deleted_by": null,
      "created_at": "2018-05-16 13:25:03",
      "updated_at": "2018-05-16 13:25:03",
      "deleted_at": null,
      "status_text": "Confirmed"
    }
  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!"
}
              </pre>
        </div>
        <!-- end invoice list api content -->

        <!-- start invoice detail download api content -->
        <div id="invoice_detail_download_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_invoice_detail</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "invoice_detail": {
        "invoice_id": "INV20180521000001"
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "data": {
    "id": "INV20180521000001",
    "order_date": "2018-05-16",
    "delivery_date": "2018-05-18",
    "total_payable_amt": 4950,
    "retailshop_name_eng": "Pyae Sone (1)",
    "retailshop_name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1041)",
    "retailshop_address": "No(59), Kan Lann, Hlaing, Yangon",
    "status_text": "Auderbox Cancelled",
    "invoice_detail": [
      {
        "id": "5b02d249ccba69.52102058",
        "invoice_id": "INV20180521000001",
        "product_id": 1,
        "product_group_id": 1,
        "uom_id": 1,
        "status": 2,
        "uom": "pack",
        "quantity": 6,
        "unit_price": 350,
        "net_amt": 2000,
        "discount_amt": 250,
        "net_amt_w_disc": 1750,
        "tax_amt": 175,
        "payable_amt": 1925,
        "remark": "test test",
        "confirm_by": null,
        "confirm_date": null,
        "cancel_by": null,
        "cancel_date": null,
        "product_name": "Coca Cola",
        "product_uom_type_name_eng": "unit",
        "product_uom_type_name_mm": "\u101c\u102f\u1036\u1038",
        "total_uom_quantity": 1,
        "product_volume_type_name": "330 ml",
        "product_container_type_name": "Glass Bottle",
        "status_text": "Confirmed"
      },
      {
        "id": "5b02d249cce253.89040335",
        "invoice_id": "INV20180521000001",
        "product_id": 2,
        "product_group_id": 1,
        "uom_id": 1,
        "status": 2,
        "uom": "pack",
        "quantity": 6,
        "unit_price": 350,
        "net_amt": 2000,
        "discount_amt": 250,
        "net_amt_w_disc": 1750,
        "tax_amt": 175,
        "payable_amt": 1925,
        "remark": "test test",
        "confirm_by": null,
        "confirm_date": null,
        "cancel_by": null,
        "cancel_date": null,
        "product_name": "Coca Cola",
        "product_uom_type_name_eng": "pack",
        "product_uom_type_name_mm": "\u1000\u1010\u1039",
        "total_uom_quantity": 6,
        "product_volume_type_name": "330 ml",
        "product_container_type_name": "Glass Bottle",
        "status_text": "Confirmed"
      }
    ]
  },
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!"
}
              </pre>
        </div>
        <!-- end invoice detail api content -->

        <!-- start add to cart upload api content -->
        <div id="add_to_cart_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/add_to_cart</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "add_to_cart": {
        "retailer_id": 1,
        "retailshop_id": 1,
        "brand_owner_id": 1,
        "product_id": 1,
        "quantity": 1
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "data": [

  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Cart data is successfully saved!",
  "cart_item_count": 5
}
              </pre>
        </div>
        <!-- end add to cart upload api content -->

        <!-- start update cart qty api content -->
        <div id="update_cart_qty_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/update_cart_qty</b></p>
            <hr>
            <p>Remark : <b>If quantity is zero, the product will be removed from cart</b></p>
            <hr>
            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "add_to_cart": {
        "retailer_id": 1,
        "retailshop_id": 1,
        "brand_owner_id": 1,
        "product_id": 1,
        "quantity": 1
      }
    }
  ]
}
              </pre>

              <hr>
              <h3>Response</h3>
              <pre>
{
  "data": [

  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Cart data is successfully saved!"
}
              </pre>
        </div>
        <!-- end update cart qty api content -->

        <!-- start download cart list api content -->
        <div id="download_cart_list_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_cart_list</b></p>
            <hr>

            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "cart_list": {
        "retailer_id": 1,
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
  "data": [
    {
      "cart_list": [
        {
          "id": "20180612000001",
          "retailer_id": 1,
          "retailshop_id": 1,
          "brand_owner_id": 1,
          "product_id": 1,
          "quantity": 1,
          "created_date": "2018-06-12 09:31:04",
          "maximum_qty": 50,
          "product_name": "Coca-Cola",
          "product_uom_type_name_eng": "24 cans\/ case",
          "product_uom_type_name_mm": "24 cans\/ case",
          "product_volume_type_name": "250 ml\r\n",
          "product_container_type_name": "can",
          "total_uom_quantity": "24",
          "price": 7200,
          "payable_amount": 7200
        }
      ],
      "total_payable_amount": 7200
    }
  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Cart list downloaded successfully !"
}
              </pre>
        </div>
        <!-- end download cart list api content -->

        <!-- start download order list api content -->
        <div id="download_order_list_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_order_list</b></p>
            <hr>

            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "cart_list": {
        "retailer_id": 1,
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
  "data": [
    {
      "order_list": [
        {
          "product_id": 8,
          "product_name": "Sprite",
          "quantity": 10,
          "product_uom_type_name_eng": "24 cans\/ case",
          "product_uom_type_name_mm": "24 cans\/ case",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "can",
          "total_uom_quantity": 24,
          "maximum_qty": 50,
          "price": 7200,
          "payable_amount": 72000
        },
        {
          "product_id": 1,
          "product_name": "Coca-Cola",
          "quantity": 10,
          "product_uom_type_name_eng": "24 cans\/ case",
          "product_uom_type_name_mm": "24 cans\/ case",
          "product_volume_type_name": "250 ml\r\n",
          "product_container_type_name": "can",
          "total_uom_quantity": 24,
          "maximum_qty": 50,
          "price": 7200,
          "payable_amount": 72000
        },
        {
          "product_id": 35,
          "product_name": "Max2O Pure Drinking Water",
          "quantity": 2,
          "product_uom_type_name_eng": "6 bottles\/ case",
          "product_uom_type_name_mm": "6 bottles\/ case",
          "product_volume_type_name": "1 L\r\n",
          "product_container_type_name": "bottle",
          "total_uom_quantity": 6,
          "maximum_qty": 0,
          "price": 0,
          "payable_amount": 0
        }
      ],
      "total_payable_amount": 144000
    }
  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Order list downloaded successfully !"
}
              </pre>
        </div>
        <!-- end download order list api content -->

        <!-- start clear cart list api content -->
        <div id="clear_cart_list_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/clear_cart_list</b></p>
            <hr>

            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "clear_cart_list": {
        "retailer_id": 1,
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
  "aceplusStatusMessage": "Cart data is successfully cleared !",
  "data": []
}
              </pre>
        </div>
        <!-- end clear cart list api content -->

        <!-- start checkout cart api content -->
        <div id="checkout_cart_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/checkout_cart_list</b></p>
            <hr>

            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "checkout_cart": {
        "retailer_id": 1,
        "retailshop_id": 1,
        "delivery_date": "2018-06-15"
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
  "aceplusStatusMessage": "Cart is checked out successfully !",
  "data": []
}
              </pre>
        </div>
        <!-- end checkout cart api content -->

        <!-- start download item level promotion api content -->
        <div id="download_item_level_promotion_api" class="tab-pane fade in">
            <h3>URL</h3>
            <p><b>http://localhost:8000/api/download_item_level_promotions</b></p>
            <hr>

            <h3>Request</h3>
            <pre>
{
  "site_activation_key": "1234567",
  "data": [
    {
      "download_item_level_promotions": {
        "retailer_id": 1,
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
  "data": [
    {
      "received_promotion": {
        "id": 1,
        "promotion_item_level_group_id": 1,
        "product_line_id": 1,
        "code": "00001",
        "name": "Item Level Promotion 1 (quantity)",
        "promotion_image": "\/images\/product_images\/Max2O Pure Drinking Water (1 L) x 6.png",
        "promo_purchase_type": 1,
        "promo_present_type": 1,
        "from_date": "2018-06-01",
        "to_date": "2018-06-30",
        "purchase_amt": 0,
        "purchase_qty": 5,
        "promo_percentage": 0,
        "promo_amt": 0,
        "max_count_apply": 0,
        "promo_allow_max_count": 10,
        "remark": null,
        "status": 1,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "product_line_name": "Coca-Cola",
        "promotion_product_id_array": [
          1,
          2,
          3,
          4,
          5,
          6,
          7
        ],
        "cart_item_array_included_in_promotion": [
          {
            "id": "20180614000001",
            "retailer_id": 1,
            "retailshop_id": 1,
            "brand_owner_id": 1,
            "product_id": 2,
            "quantity": 37,
            "created_date": "2018-06-14 10:07:13"
          }
        ],
        "promo_purchase_type_text": "Quantity Promotion",
        "promo_present_type_text": "Quantity Promotion",
        "current_purchase_qty": 37,
        "current_purchase_amt": 266400
      },
      "product_array": [
        {
          "id": 2,
          "product_group_id": 2,
          "product_uom_type_id": 1,
          "image": "\/images\/product_images\/Coca Cola (330 ml) x 24.png",
          "sku": "COCA-COLA-000002",
          "remark": "A product of Coca-Cola Family",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 7200,
          "name": "Coca-Cola",
          "product_uom_type_name_eng": "24 cans\/ case",
          "product_uom_type_name_mm": "24 cans\/ case",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "can",
          "total_uom_quantity": 24,
          "product_line_id": 1,
          "product_line_name": "Coca-Cola",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "purchase_qty": 37
        }
      ],
      "promo_product_array": [
        {
          "id": 2,
          "promotion_item_level_id": 2,
          "promo_product_id": 36,
          "promo_qty": 1,
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "promo_product_name": "Max2O Pure Drinking Water",
          "received_promo_qty": 7
        }
      ],
      "additional_qty": 3,
      "additional_amt": 0,
      "current_purchase_qty": 37
    }
  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Downloaded Promotion Data Successfully !"
}
              </pre>
        </div>
        <!-- end download item level promotion api content -->
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
