$(".hida_item").on('click', function() {
    $(".multiselect_item").slideToggle('fast');
});

$('.multiselect_item').on('click', '.par', function (e) {//don't toggle the span tag which contains the + or - signs
    if(e.target == e.currentTarget) {//check whether parent element is clicked
        //alert('parent element clicked');
        $(this).children().not("#sign").toggle();
    }

    var id = $(this).attr('id');//get value of id attribute to add in html()
    //check action of toggle is visible or hidden
    var isVisible = $(this).children().is(":visible");//if visible , return true
    var isHidden = $(this).children().is(":hidden");//if hidden , return false
    if(isVisible){
        $(this).children('span').text("- ");
    }
    if(isHidden){
        $(this).children('span').text("+ ");
    }
});
//can check only one checkbox

$('.multiselect_item').on('click', '.item_check', function () {
    $('.item_check').not(this).prop('checked',false);
});

//pass checkbox value to text box
$('.multiselect_item').on('click', '.item_check', function () {
    var res = $(this).val();
    //alert(res);
    $('#category').val(res);
});