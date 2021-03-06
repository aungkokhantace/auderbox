function check_date(from_date, to_date){

    var dateFirst = from_date.split('-');
    var dateSecond = to_date.split('-');
    var dateFistTemp = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
    var dateSecondTemp = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);

    if(dateSecondTemp < dateFistTemp){
        return false;
    }
    else{
        return true;
    }
}

function report_search_by_date_and_status(module) {
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var status = $("#status").val();

    if(from_date == "" && to_date == ""){
        sweetAlert("Oops...", "Please Choose the date !");
        return;
    }
    else if(from_date == "" && to_date != "") {
        sweetAlert("Oops...", "Please Choose the date !");
        return;
    }
    else if(from_date != "" && to_date == "") {
        sweetAlert("Oops...", "Please Choose the date !");
        return;
    }
    else{
        var dateComparison = check_date(from_date, to_date);

        if(dateComparison){
            var form_action = "/backend/"+module+"/search/"+ from_date + "/" + to_date + "/" + status;
        }
        else{
            sweetAlert("Oops...", "Please Choose the valid date !");
            return;
        }
    }
    window.location = form_action;
}

function deliver_invoice(invoice_id) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55 ",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              $('.confirm').attr('disabled','disabled');
              $("#frm_invoice_delivery_" + invoice_id).submit();
            } else {
              return;
            }
        });
}

function cancel_invoice(invoice_id) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55 ",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              $('.confirm').attr('disabled','disabled');
              $("#frm_invoice_cancel_" + invoice_id).submit();
            } else {
              return;
            }
        });
}

function partial_deliver_invoice(invoice_id) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55 ",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              $('.confirm').attr('disabled','disabled');
              $("#frm_invoice_partial_delivery_" + invoice_id).submit();
            } else {
              return;
            }
        });
}

function partial_cancel_invoice(invoice_id) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55 ",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              $('.confirm').attr('disabled','disabled');
                $("#frm_invoice_partial_cancel_" + invoice_id).submit();
            } else {
                return;
            }
        });
}

function redirect_to_invoice_report() {
  window.location = "/backend/invoice_report";
}

function invoice_report_csv_export() {
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var status = $("#status").val();

    if(from_date == "" && to_date == ""){
        var form_action = "/backend/invoice_report/export_csv/";
    }
    else if(from_date == "" && to_date != "") {
        sweetAlert("Oops...", "Please Choose the date !");
        return;
    }
    else if(from_date != "" && to_date == "") {
        sweetAlert("Oops...", "Please Choose the date !");
        return;
    }
    else{
        var dateComparison = check_date(from_date, to_date);

        if(dateComparison){
            var form_action = "/backend/invoice_report/export_csv/"+ from_date + "/" + to_date + "/" + status;
        }
        else{
            sweetAlert("Oops...", "Please Choose the valid date !");
            return;
        }
    }
    window.location = form_action;
}

function change_invoice_detail_quantity(invoice_detail_id) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55 ",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
              $('.confirm').attr('disabled','disabled');
              $("#frm_change_qty_" + invoice_detail_id).submit();
            } else {
              return;
            }
        });
}
