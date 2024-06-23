$(document).ready(function() {

    //assets
    //assets
    //assets
    //assets
    //this is for asset dynamic in selecting asset id and modal effects
    $(document).on('click', '.asset_td', function (e) {
        e.preventDefault();
        let asset_id = $(this).closest('tr').find('.asset_id').text();
        // console.log(asset_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'asset_update':true,
                'asset_id':asset_id,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });


    //asset assignments
    // /asset assignments
    // /asset assignments
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.assets_assign_td', function (e) {
        e.preventDefault();
        let assets_assign_id = $(this).closest('tr').find('.assets_assign_id').text();
        // console.log(assets_assign_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'assets_assign_update':true,
                'asset_assign_id':assets_assign_id,
            },
            success:function(response_assign){
                // console.log(response_assign);
                $('.display').html(response_assign);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //departments
    // /departments
    // /departments
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.dept_td', function (e) {
        e.preventDefault();
        let dept_id = $(this).closest('tr').find('.dept_id').text();
        // console.log(dept_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'department_update':true,
                'department_id':dept_id,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //employees
    // /employees
    // /employees
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.emp_td', function (e) {
        e.preventDefault();
        let emp_id = $(this).closest('tr').find('.emp_id').text();
        // console.log(emp_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'employee_update':true,
                'emp_id':emp_id,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //locations
    // /locations
    // /locations
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.loc_td', function (e) {
        e.preventDefault();
        let loc_id = $(this).closest('tr').find('.loc_id').text();
        // console.log(loc_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'location_update':true,
                'loc_id':loc_id,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //position
    // /position
    // /position
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.position_td', function (e) {
        e.preventDefault();
        let position_id = $(this).closest('tr').find('.position_id').text();
        // console.log(position_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'position_update':true,
                'position_id':position_id,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //users
    // /users
    // /users
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.uid_td', function (e) {
        e.preventDefault();
        let uid = $(this).closest('tr').find('.uid').text();
        // console.log(uid);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'user_update':true,
                'user_id':uid,
            },
            success:function(response){
                // console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });

    //maintenance
    // /maintenance
    // /maintenance
    //this is for asset_assign dynamic in selecting asset assign id and modal effects
    $(document).on('click', '.maintenance_td', function (e) {
        e.preventDefault();
        let main_id = $(this).closest('tr').find('.maintenance_id').text();
        // console.log(main_id);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'maintenance_update':true,
                'maintenance_id':main_id,
            },
            success:function(response){
                console.log(response);
                $('.display').html(response);
                $('.update').css({
                    display:'flex'
                })
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });


    // depreciated value
    // depreciated value
    // depreciated value

    $(document).on('click', '.asset_depreciated', function (e) {
        e.preventDefault();
        let dep_asset_id = $(this).closest('tr').find('.asset_id').text();
        let depreciated_value = $(this).closest('tr').find('.depreciated_value').text();
        // console.log(dep_asset_id);
        // console.log(depreciated_value);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'depreciation_update':true,
                'asset_id':dep_asset_id,
                'depreciated_value':depreciated_value,
            },
            success:function(response){
                // console.log(response);
                $('#response_container').html(response);
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });


    // assign search unarchived
    // assign search unarchived
    // assign search unarchived
    // assign search unarchived
    $('#search-assign-unarchived').keyup(function() {
        var query_assign = $(this).val();
        // console.log(query_assign);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_assign_unarchived':true,
                'query_assign': query_assign,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-unarchived').html(response);
            }
        });
    });

    // assign search archived
    // assign search archived
    // assign search archived
    // assign search archived
    $('#search-assign-archived').keyup(function() {
        var query_assign = $(this).val();
        // console.log(query_assign);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_assign_archived':true,
                'query_assign': query_assign,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-archived').html(response);
            }
        });
    });
    

    // asset search unarchived
    // asset search unarchived
    // asset search unarchived
    // asset search unarchived
    $('#search-asset-unarchived').keyup(function() {
        var query_asset = $(this).val();
        // console.log(query_asset);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_asset_unarchived':true,
                'query_asset': query_asset,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-unarchived').html(response);
            }
        });
    });
    

    // asset search archived
    // asset search archived
    // asset search archived
    // asset search archived
    $('#search-asset-archived').keyup(function() {
        var query_asset = $(this).val();
        // console.log(query_asset);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_asset_archived':true,
                'query_asset': query_asset,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-archived').html(response);
            }
        });
    });
    

    // employees search unarchived
    // employees search unarchived
    // employees search unarchived
    // employees search unarchived
    $('#search-employee-unarchived').keyup(function() {
        var query_employee = $(this).val();
        // console.log(query_employee);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_employee_unarchived':true,
                'query_employee': query_employee,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-unarchived').html(response);
            }
        });
    });
    


    // employees search archived
    // employees search archived
    // employees search archived
    // employees search archived
    $('#search-employee-archived').keyup(function() {
        var query_employee = $(this).val();
        // console.log(query_employee);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_employee_archived':true,
                'query_employee': query_employee,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-archived').html(response);
            }
        });
    });



    // maintenance search unarchived
    // maintenance search unarchived
    // maintenance search unarchived
    // maintenance search unarchived
    $('#search-maintenance-unarchived').keyup(function() {
        var query_maintenance = $(this).val();
        // console.log(query_maintenance);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_maintenance_unarchived':true,
                'query_maintenance': query_maintenance,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search-unarchived').html(response);
            }
        });
    });



    // depreciated search
    // depreciated search
    // depreciated search
    // depreciated search
    $('#search-depreciated').keyup(function() {
        var query_depreciated = $(this).val();
        // console.log(query_depreciated);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'search_depreciated':true,
                'query_depreciated': query_depreciated,
            },
            success: function(response) {
                // console.log(response);
                $('#table-search').html(response);
            }
        });
    });



    // scanning barcode assign
    // scanning barcode assign
    // scanning barcode assign
    // scanning barcode assign
    $('#barcodeInput-assign').keyup(function() {
        var query_barcode = $(this).val();
        // console.log(query_barcode);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'barcodescan_assign':true,
                'query_barcode': query_barcode,
            },
            success: function(response) {
                // console.log(response);
                $('.dynamic_info').html(response);
            }
        });
    });



    // scanning barcode maintenance
    // scanning barcode maintenance
    // scanning barcode maintenance
    // scanning barcode maintenance
    $('#barcodeInput-maintenance').keyup(function() {
        var query_barcode = $(this).val();
        // console.log(query_barcode);

        $.ajax({
            url: '../control/controller.php',
            method: 'POST',
            data: { 
                'barcodescan_maintenance':true,
                'query_barcode': query_barcode,
            },
            success: function(response) {
                // console.log(response);
                $('.dynamic_info').html(response);
            }
        });
    });
    

    const clearButton = document.querySelector('.clear');
    clearButton.addEventListener('click', function() {
        barcodeInput.value = '';
        document.getElementById('assetBrandName').value = '';
    });   


    //this is for all modals that are appearing will close it 
    $('.close').on('click', function () {
        // console.log('Close');
        $('.update').css({
            display: 'none'
        });
    });

    
});
  