<?php
date_default_timezone_set('Europe/Madrid');
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";

switch ($_POST['api']) {
    case 'add':
        if (checkConnection()) {
            insertDataList(selectIdList());
            getList();
        }
        break;
    case 'get':
        if (checkConnection()) {
            getList();
        }
        break;
    default:
        break;
}
function checkConnection()
{
    $conn = new mysqli('localhost', 'root', '');
    if ($conn->connect_error) {
        return false;
    } else {
        return true;
    }
    $conn->close();
}
function selectIdList()
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql_id = "SELECT id FROM listas WHERE tablename='" . $_POST['name'] . "';";
    $result = $conn->query($sql_id);
    $usuario = new stdClass();
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $usuario->id = $row['id'];
        }
    }
    $conn->close();
    return $usuario->id;
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
    $sql = "SELECT * FROM listaobjetos WHERE idlist='" . selectIdList() . "';";
    $result = $conn->query($sql);

    $taskArray = [];
    if ($result->num_rows > 0) {
        // echo 'INNNNNNNNN';
        while ($row = $result->fetch_assoc()) {
            $task = new stdClass();
            $task->task = $row['task'];
            $task->lenguage = $row['lenguage'];
            $task->descripcion = $row['descripcion'];
            array_push($taskArray, $task);
        }
    } else {
        echo 'OUTTTTTTTTT';
    }
    $conn->close();
    echo json_encode($taskArray);
}
