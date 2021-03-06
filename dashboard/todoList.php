<?php
date_default_timezone_set('Europe/Madrid');
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";

switch ($_POST['api']) {
    case 'add':
        if (checkConnection()) {
            insertDataList($_POST['id']);
            getList();
        }
        break;
    case 'get':
        if (checkConnection()) {
            getList();
        }
        break;
    case 'delete':
        if (checkConnection()) {
            deleteRow($_POST['idrow']);
            getList();
        }
        break;
    default:
        break;
}
function checkConnection()
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD);
    if ($conn->connect_error) {
        return false;
    } else {
        return true;
    }
    $conn->close();
}
function insertDataList($idList)
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = 'INSERT INTO listaobjetos (idlist, task, lenguage, descripcion) VALUES ("' . $idList . '","' . $_POST['task'] . '","' . $_POST['lang'] . '","' . $_POST['textarea'] . '");';
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    $conn->close();
}
function getList()
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "SELECT * FROM listaobjetos WHERE idlist='" . $_POST['id'] . "';";
    $result = $conn->query($sql);

    $taskArray = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $task = new stdClass();
            $task->task = $row['task'];
            $task->lenguage = $row['lenguage'];
            $task->descripcion = $row['descripcion'];
            $task->id = $row['id'];
            array_push($taskArray, $task);
        }
    } else if ($result->num_rows == 0) {
        $task = 'empty';
        array_push($taskArray, $task);
    } else {
        echo $result->num_rows;
    }
    $conn->close();
    echo json_encode($taskArray);
}
function deleteRow($id)
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql_a = "DELETE FROM listaobjetos WHERE id='" . $id . "';";
    $conn->query($sql_a);
    $conn->close();
}
