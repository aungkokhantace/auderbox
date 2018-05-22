@extends('layouts.master')
@section('title','Dashboard')
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
          "image": "\/images\/product_images\/Max_Power_Strawberry_350mL Bottle_Dry_LR.jpg",
          "sku": "coca-0001",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 300,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "unit",
          "product_uom_type_name_mm": "\u101c\u102f\u1036\u1038",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "Glass Bottle",
          "total_uom_quantity": "1",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 2,
          "product_group_id": 1,
          "product_uom_type_id": 2,
          "image": "\/images\/product_images\/MAX+_Frontier_ 1.5L_Wet_LR.jpg",
          "sku": "coca-0002",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "pack",
          "product_uom_type_name_mm": "\u1000\u1010\u1039",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "Glass Bottle",
          "total_uom_quantity": "6",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 3,
          "product_group_id": 1,
          "product_uom_type_id": 3,
          "image": "\/images\/product_images\/MAX+_Frontier_ 330ml_Wet_LR.jpg",
          "sku": "coca-0003",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 400,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "\u102edozen",
          "product_uom_type_name_mm": "\u1012\u102b\u1007\u1004\u1039",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "Glass Bottle",
          "total_uom_quantity": "12",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 4,
          "product_group_id": 1,
          "product_uom_type_id": 4,
          "image": "\/images\/product_images\/Max+_Frontier_lychee_350mL_Dry_LR.jpg",
          "sku": "coca-0004",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 900,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "carton",
          "product_uom_type_name_mm": "\u1000\u102c\u1010\u103c\u1014\u1039",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "Glass Bottle",
          "total_uom_quantity": "24",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 5,
          "product_group_id": 1,
          "product_uom_type_id": 5,
          "image": "\/images\/product_images\/Max+C_Frontier_330mL_Dry_LR.jpg",
          "sku": "coca-0005",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 900,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "box",
          "product_uom_type_name_mm": "\u1031\u101e\u1010\u1071\u102c",
          "product_volume_type_name": "330 ml",
          "product_container_type_name": "Glass Bottle",
          "total_uom_quantity": "50",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 6,
          "product_group_id": 2,
          "product_uom_type_id": 1,
          "image": "\/images\/product_images\/Max+C_Frontier_350mL_Dry_LR.jpg",
          "sku": "coca-0006",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 1200,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "unit",
          "product_uom_type_name_mm": "\u101c\u102f\u1036\u1038",
          "product_volume_type_name": "350 ml",
          "product_container_type_name": "Plastic Bottle",
          "total_uom_quantity": "1",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 7,
          "product_group_id": 2,
          "product_uom_type_id": 2,
          "image": "\/images\/product_images\/OB_Coca-Cola 1.5L_Dry_LR.jpg",
          "sku": "coca-0007",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 330,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "pack",
          "product_uom_type_name_mm": "\u1000\u1010\u1039",
          "product_volume_type_name": "350 ml",
          "product_container_type_name": "Plastic Bottle",
          "total_uom_quantity": "6",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 8,
          "product_group_id": 2,
          "product_uom_type_id": 3,
          "image": "\/images\/product_images\/OB_Coca-Cola 250mL_Dry_LR.jpg",
          "sku": "coca-0008",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 320,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "\u102edozen",
          "product_uom_type_name_mm": "\u1012\u102b\u1007\u1004\u1039",
          "product_volume_type_name": "350 ml",
          "product_container_type_name": "Plastic Bottle",
          "total_uom_quantity": "12",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 9,
          "product_group_id": 2,
          "product_uom_type_id": 4,
          "image": "\/images\/product_images\/OB_Coca-Cola_Zero_330mL_Dry_LR.jpg",
          "sku": "coca-0009",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 320,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "carton",
          "product_uom_type_name_mm": "\u1000\u102c\u1010\u103c\u1014\u1039",
          "product_volume_type_name": "350 ml",
          "product_container_type_name": "Plastic Bottle",
          "total_uom_quantity": "24",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 10,
          "product_group_id": 2,
          "product_uom_type_id": 5,
          "image": "\/images\/product_images\/Schweppes_Dry_Ginger_Ale_330ml_Dry_LR.jpg",
          "sku": "coca-0010",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 340,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "box",
          "product_uom_type_name_mm": "\u1031\u101e\u1010\u1071\u102c",
          "product_volume_type_name": "350 ml",
          "product_container_type_name": "Plastic Bottle",
          "total_uom_quantity": "50",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 11,
          "product_group_id": 3,
          "product_uom_type_id": 1,
          "image": "\/images\/product_images\/Schweppes_Soda_Water_330ml_Dry_LR.jpg",
          "sku": "coca-0011",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "unit",
          "product_uom_type_name_mm": "\u101c\u102f\u1036\u1038",
          "product_volume_type_name": "1.5 l",
          "product_container_type_name": "Aluminium Can",
          "total_uom_quantity": "1",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 12,
          "product_group_id": 3,
          "product_uom_type_id": 2,
          "image": "\/images\/product_images\/Sprite_1.5L_Dry_LR.jpg",
          "sku": "coca-0012",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "pack",
          "product_uom_type_name_mm": "\u1000\u1010\u1039",
          "product_volume_type_name": "1.5 l",
          "product_container_type_name": "Aluminium Can",
          "total_uom_quantity": "6",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 13,
          "product_group_id": 3,
          "product_uom_type_id": 3,
          "image": "\/images\/product_images\/Sprite_330ml_Dry_LR.jpg",
          "sku": "coca-0013",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "\u102edozen",
          "product_uom_type_name_mm": "\u1012\u102b\u1007\u1004\u1039",
          "product_volume_type_name": "1.5 l",
          "product_container_type_name": "Aluminium Can",
          "total_uom_quantity": "12",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 14,
          "product_group_id": 3,
          "product_uom_type_id": 4,
          "image": "\/images\/product_images\/Max+_Frontier_Lime_600mL_Dry_LR.jpg",
          "sku": "coca-0014",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "carton",
          "product_uom_type_name_mm": "\u1000\u102c\u1010\u103c\u1014\u1039",
          "product_volume_type_name": "1.5 l",
          "product_container_type_name": "Aluminium Can",
          "total_uom_quantity": "24",
          "minimum_order_qty": 1,
          "maximum_order_qty": 50,
          "out_of_stock_flag": 0
        },
        {
          "id": 15,
          "product_group_id": 3,
          "product_uom_type_id": 5,
          "image": "\/images\/product_images\/MAX+_Frontier_ 330ml_Wet_LR.jpg",
          "sku": "coca-0015",
          "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
          "status": 1,
          "created_by": 1,
          "updated_by": 1,
          "deleted_by": null,
          "created_at": null,
          "updated_at": null,
          "deleted_at": null,
          "price": 350,
          "name": "Coca Cola",
          "product_uom_type_name_eng": "box",
          "product_uom_type_name_mm": "\u1031\u101e\u1010\u1071\u102c",
          "product_volume_type_name": "1.5 l",
          "product_container_type_name": "Aluminium Can",
          "total_uom_quantity": "50",
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
        "product_group_id": 1,
        "product_uom_type_id": 1,
        "image": "\/images\/product_images\/Max_Power_Strawberry_350mL Bottle_Dry_LR.jpg",
        "sku": "coca-0001",
        "remark": "Coca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in historyCoca Cola 1.5L is the most popular and biggest selling soft drink in history",
        "status": 1,
        "created_by": 1,
        "updated_by": 1,
        "deleted_by": null,
        "created_at": null,
        "updated_at": null,
        "deleted_at": null,
        "price": 300,
        "name": "Coca Cola",
        "product_uom_type_name_eng": "unit",
        "product_uom_type_name_mm": "\u101c\u102f\u1036\u1038",
        "product_volume_type_name": "330 ml",
        "product_container_type_name": "Glass Bottle",
        "total_uom_quantity": "1",
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
              "id": "5abdfdfsdfd",
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
              "remark": "test test"
            },
            {
              "id": 2,
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
              "remark": "test test"
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
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!",
  "data": [

  ]
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
        "filter": "all"
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
      "deleted_by": 0,
      "created_at": 1526453703,
      "updated_at": 1526453703,
      "deleted_at": null,
      "retailshop_name_eng": "Pyae Sone (1)",
      "retailshop_name_mm": "\u103b\u1015\u100a\u1037\u1039\u1005\u102f\u1036 (\u1041)",
      "retailshop_address": "No(59), Kan Lann, Hlaing, Yangon",
      "status_text": "Confirmed",
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
    }
  ],
  "aceplusStatusCode": 200,
  "aceplusStatusMessage": "Success!"
}
              </pre>
        </div>
        <!-- end invoice list api content -->
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
