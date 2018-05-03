/**
 * Created by Dell on 3/24/2016.
 */

$(document).ready(function(){

    $('.sub').hide();
    $('.selectedValue').hide();
    $('.multiselect').hide();


    $(".hida").on('click', function() {
        $(".multiselect").slideToggle('fast');
    });

    $('.multiselect').find('.main').click(function(){
        $(this).next().toggle(); //Expand or collapse this panel
        var id = $(this).attr('id');//get value of id attribute to add in html()
        //check action of toggle is visible or hidden
        var isVisible = $(this).next().is(":visible");//if visible , return true
        var isHidden = $(this).next().is(":hidden");//if hidden , return false
        if(isVisible){
            $(this).html("-"+id);//change + to -
        }
        if(isHidden){
            $(this).html("+ "+id);//change - to +
        }
    });

    //Displaying selected value in span
    $('.sub input[type="checkbox"]').on('click', function() {

       $(".hida").hide();
        $('.selectedValue').show();


        var title  = $(this).parent().find('span').html(),
            title=$(this).parent().find('span').html()+",";


        if ($(this).is(':checked')) {
            var html = '<span title="' + title + '">' + title + '</span>';
            $('.selectedValue').append(html);

        } else {
            $('span[title="' + title + '"]').remove();
        }
    });

});

