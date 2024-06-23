
$(document).ready(function() {

    //this is for upgrading select element
    $('.select_two').select2();

    //displaying asset_brandname in maintenance add and asset_assigning add
    $('#asset_id').on('select2:select', function (e) {
        var brandname = $(this).find(':selected').data('brandname');
        var depreciated_value = $(this).find(':selected').data('depvalue');
        console.log(brandname);
        console.log(depreciated_value);
        $('#asset_brandname').val(brandname);
        $('#depreciated_value').val(depreciated_value);
    });

});
