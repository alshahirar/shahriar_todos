<?php
// Include config.php file
require 'vendor/autoload.php';

$dbObj = new Database();


// Edit Record with editable list
if (isset($_POST['OriginalContent']) && isset($_POST['newContent'])) {
    $newcontent = $_POST['newContent'];
    $oldcontent = $_POST['OriginalContent'];
    $dbObj->edit($newcontent, $oldcontent);
}

// Insert Record
if ($_POST['action'] == "insert") {

   $task = trim($_POST["task"]);
   $userID = 1;
   $task_status = "no";

    $dbObj->insertRecord($task, $userID, $task_status);
}

// Delete Record
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    $task_id = $_POST['task_list_id'];

    $dbObj->deleteRecord($task_id);
}

// Update Record
if (isset($_POST['action']) && $_POST['action'] == "update") {
    $task_id = $_POST['task_list_id'];

    if($_POST['value'] == "true"){

        $value = "yes";

    }else {$value = "no";}

    $dbObj->updateRecord($task_id, $value);
}

// clear completed
if (isset($_POST['action']) && $_POST['action'] == "clear") {
    $dbObj->clearCompleted();
}

$active = $_POST['action'];
// View record
if ((isset($_POST['action']) && $_POST['action'] == "view") || $_POST['action'] == "active" || $_POST['action'] == "completed") {
    $output = "";

    $tasks = $dbObj->displayRecord($active);

    if ($dbObj->totalRowCount() > 0) {

        $output .= "";

        if (is_array($tasks) || is_object($tasks)) {
            foreach ($tasks as $task) {
                $style = '';
                $status = '';
                if ($task["task_status"] == 'yes') {
                    $style = 'text-decoration: line-through';

                    $status = "checked";
                }

                echo '<div class="item"><a href="#" style="' . $style . '" class="list-group-item  cellEditing" id="list-group-item-' . $task["task_list_id"] . '" data-id="' . $task["task_list_id"] . '"><input id="updateCheckBox" class="toggle taskStatus" data-id="' . $task["task_list_id"] . '" type="checkbox" '. $status .'>&ensp;' . $task["task_details"] . ' <i class="destroy fa fa-trash-o" id="list-group-item-' . $task["task_list_id"] . '" data-id="' . $task["task_list_id"] . '" style="font-size:24px"></i> </a> </div>';

            }
        }
        ?>
        <!--footer session Items-- ALL-- Complete-->
        <footer class="footer" id="footer" style="display: block;">
            <span class="todo-count" id="count"><strong><?php echo $dbObj->incompetedTaskCount(); ?></strong> item left</span>
            <ul class="filters">
                <li><a href="#/" id="all" class="<?php if ($active == "view") {
                        echo "selected";
                    } ?>">All</a></li>
                <li><a href="#/active" id="active" class="<?php if ($active == "active") {
                        echo "selected";
                    } ?>">Active</a></li>
                <li><a href="#/completed" id="completed" class="<?php if ($active == "completed") {
                        echo "selected";
                    } ?>">Completed</a></li>
            </ul>
            <?php if ($dbObj->competedTaskCount() > 0) { ?>
                <button class="clear-completed" id="clear-completed" style=""> Clear completed [<span id="completed-count"><?php echo $dbObj->competedTaskCount(); ?></span>]</button>
            <?php } ?>
        </footer>
        <?php
    }
}
?>
<!--JS for editable table and checkbox update-->
<script>
    $(function () {
        $("a").dblclick(function () {
            var OriginalContent = $(this).text().trim();
            $(this).addClass("cellEditing");
            $(this).html("<input  type='text' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function (e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    if ($(this).val() == "" || !newContent.trim().length) {
                        $.notify("Task Field is Empty", "error");
                        location.reload()
                        return false;
                    } else {
                        $.ajax({
                            url: "action.php",
                            method: "POST",
                            data: { OriginalContent: OriginalContent, newContent: newContent },
                            success: function (data) {
                                $.notify("Task Update", "success");
                                location.reload()
                            },
                        });
                    }
                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");
                }
            });
            $(this).children().first().blur(function(){
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
                location.reload()
            });
            $(this).find('input').dblclick(function(e){
                e.stopPropagation();
            });
        });
    });
    $(".taskStatus").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
            var value =$(this).attr('value');
            var task_list_id = $(this).data('id');
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{task_list_id:task_list_id,action:"update",value:value},
                success:function(data)
                {
                    $.notify("Task Completed", "success");
                    location.reload()
                }
            })
        } else {
            var task_list_id = $(this).data('id');
            $(this).attr('value', 'false');
            var value =$(this).attr('value');
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{task_list_id:task_list_id,action:"update",value:value},
                success:function(data)
                {
                    $.notify("Task Status Update", "warn");
                    location.reload()
                }
            })
        }
    });
</script>