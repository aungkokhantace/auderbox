/**
 * Created by Dell on 3/29/2016.
 */
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy (D)',
    autoclose: true,
    keyboardNavigation : true ,
    endDate : dateFormat(date, "dd/mm/yyyy (ddd)"),
    daysOfWeekDisabled : [0]
});