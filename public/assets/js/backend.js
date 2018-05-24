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
