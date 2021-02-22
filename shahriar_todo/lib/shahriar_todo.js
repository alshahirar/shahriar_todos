$(document).ready(function () {
    showAllCustomer();
    //View Record
    function showAllCustomer() {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: { action: "view" },
            success: function (response) {
                $("#tableData").html(response);
                //$("table").DataTable({
                // order:[0, 'DESC']
                //});
            },
        });
    }
    $(document).on("submit", "#insert_from", function (event) {
        event.preventDefault();
        var val = $("#task").val();
        // this condition checks if there's whitespace at the beginning
        // or if the string is empty
        // if either is true we disable the button
        if ($("#task").val() == "" || !val.trim().length) {
            $.notify("Task Field is Empty", "error");
            return false;
        } else {
            $("#submit").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "action.php",
                data: { action: "insert",task: $("#task").val()},
                success: function (data) {
                    $.notify("Access granted", "success");
                    $("#submit").attr("disabled", false);
                    $("#insert_from")[0].reset();
                    $("#showinfo").html(data);
                    showAllCustomer();
                },
            });
        }
    });
    $(document).on("click", ".destroy", function () {
        var task_list_id = $(this).data("id");
        var task_list_id_id = $(this).attr('id');
        if ( task_list_id_id == "list-group-item-"+ task_list_id ) {
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {action: "delete", task_list_id: task_list_id },
                success: function (data) {
                    $("#list-group-item-" + task_list_id).fadeOut("slow");
                    $.notify("Task Deleted", "success");
                },
            });
        }else{
            $.notify("Delete failed", "error");
            return false;
        }
    });

    $(document).on("click", "#all", function () {
        $.notify("All Task", "Success");
        showAllCustomer();
    });
    $(document).on("click", "#active", function () {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: { action: "active" },
            success: function (response) {
                $("#tableData").html(response);
                //$("table").DataTable({
                // order:[0, 'DESC']
                //});
            },
        });
    });
    $(document).on("click", "#completed", function () {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: { action: "completed" },
            success: function (response) {
                $("#tableData").html(response);
                //$("table").DataTable({
                // order:[0, 'DESC']
                //});
            },
        });
    });
    $(document).on("click", "#clear-completed", function () {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: { action: "clear" },
            success: function (data) {
                $.notify("Clear", "success");
                showAllCustomer();

            },
        });
    });
});