<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "shahriar_todo";
    public $con;
    public $customerTable = "task_list";
    /*Database connecting*/
    public function __construct()
    {
        try {
            $this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    /*insert task*/
    public function insertRecord($task, $userID, $task_status)
    {
        $sql = "INSERT INTO `task_list`(`user_id`, `task_details`, `task_status`) VALUES ('$userID','$task','$task_status')";
        $query = $this->con->query($sql);

        if ($query == true) {
            echo "Insert";
        } else {
            echo "Task Insert failed";
        }
    }

    // Fetch customer records for show listing
    public function displayRecord($action)
    {
        if ($action == "view") {
            $sql = "SELECT * FROM $this->customerTable";
        } elseif ($action == "completed") {
            $sql = "SELECT * FROM `task_list` WHERE `task_status` = 'yes'";
        } else {
            $sql = "SELECT * FROM `task_list` WHERE `task_status` = 'no'";
        }
        $query = $this->con->query($sql);
        $data = [];
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
    /*List edit with editable input*/
    public function edit($newcontent, $oldcontent)
    {
        $sql = "UPDATE `task_list` SET `task_details`= '$newcontent' WHERE `task_details` = '$oldcontent'";
        $query = $this->con->query($sql);
        if ($query == true) {
            echo "Record  delete";
        } else {
            echo "Record does not delete try again";
        }
    }
    /*uncheckd in completed task list*/
    public function incompetedTaskCount()
    {
        $sql = "SELECT * FROM `task_list` WHERE `task_status` = 'no'";
        $query = $this->con->query($sql);
        $rowCount = $query->num_rows;
        return $rowCount;
    }
    /*completed task list*/
    public function competedTaskCount()
    {
        $sql = "SELECT * FROM `task_list` WHERE `task_status` = 'yes'";
        $query = $this->con->query($sql);
        $rowCount = $query->num_rows;
        return $rowCount;
    }
    /*clear completed task list*/
    public function clearCompleted ()
    {
        $sql = "DELETE FROM `task_list` WHERE `task_status` = 'yes'";
        $query = $this->con->query($sql);
        if ($query == true) {
            echo "Record  delete";
        } else {
            echo "Record does not delete try again";
        }
    }
    /*delete record*/
    public function deleteRecord($task_id)
    {
        $sql = "DELETE FROM `task_list` WHERE `task_list_id` = '$task_id'";
        $query = $this->con->query($sql);
        if ($query == true) {
            echo "Record  delete";
        } else {
            echo "Record does not delete try again";
        }
    }
    /*update record status*/
    public function updateRecord($task_id, $value)
    {

        $sql = "UPDATE `task_list` SET `task_status`= '$value' WHERE `task_list_id` = '$task_id' ";
        $query = $this->con->query($sql);
        if ($query == true) {
            echo "Task Status Update Completed";
        } else {
            echo "Update failed try again";
        }
    }
    /*number of task count*/
    public function totalRowCount()
    {
        $sql = "SELECT * FROM $this->customerTable";
        $query = $this->con->query($sql);
        $rowCount = $query->num_rows;
        return $rowCount;
    }
}
?>