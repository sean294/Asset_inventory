$(document).ready(function() {

    //assets
    //assets
    //assets
    //assets
    //this is for asset dynamic in selecting asset id and modal effects
    $(document).on('click', '.asset_td_unarchived', function (e) {
        e.preventDefault();
        let asset_id = $(this).closest('tr').find('.asset_id').text();
        let asset_status = $(this).closest('tr').find('.asset_status').text();
        // console.log(asset_id);
        // console.log(asset_status);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'asset_unarchived':true,
                'asset_id':asset_id,
                'asset_status':asset_status,
            },
            success:function(response){
                // console.log(response);
                $('#response_container').html(response);
                // window.location.reload();
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
    $(document).on('click', '.assets_assign_td_unarchived', function (e) {
        e.preventDefault();
        let assets_assign_id = $(this).closest('tr').find('.assets_assign_id').text();
        let assign_status = $(this).closest('tr').find('.assign_status').text();
        // console.log(assets_assign_id);
        // console.log(assign_status);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'assets_assign_unarchived':true,
                'asset_assign_id':assets_assign_id,
                'assign_status':assign_status,
            },
            success:function(response){
                // console.log(response);
                $('#response_container').html(response);
                // window.location.reload();    
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
    $(document).on('click', '.emp_unarchived_td', function (e) {
        e.preventDefault();
        let emp_id = $(this).closest('tr').find('.emp_id').text();
        let emp_status = $(this).closest('tr').find('.emp_status').text();
        // console.log(emp_id);
        // console.log(emp_status);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'employee_unarchived':true,
                'emp_id':emp_id,
                'emp_status':emp_status,
            },
            success:function(response){
                // console.log(response);
                $('#response_container').html(response);
                // window.location.reload();
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
    $(document).on('click', '.maintenance_td_unarchived', function (e) {
        e.preventDefault();
        let main_id = $(this).closest('tr').find('.maintenance_id').text();
        let maintenance_status = $(this).closest('tr').find('.maintenance_status').text();
        // console.log(main_id);
        // console.log(maintenance_status);

        $.ajax ({
            method:"post",
            url:"../control/controller.php",
            data:{
                'maintenance_unarchived':true,
                'maintenance_id':main_id,
                'maintenance_status':maintenance_status,
            },
            success:function(response){
                // console.log(response);
                $('#response_container').html(response);
                // window.location.reload();
            },
            error: function (error) {
                console.error('Error updating data:', error);
            }
            
        });

    });
    

    //this is for all modals that are appearing will close it 
    $('.close').on('click', function () {
        // console.log('Close');
        $('.update').css({
            display: 'none'
        });
    });

    
});
  