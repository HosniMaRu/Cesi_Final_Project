<?php
date_default_timezone_set('Europe/Madrid');
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";
$response = new stdClass();

switch ($_POST['api']) {
    case 'get':
        if (checkConnection()) {
            getData();
        }
        break;
    case 'modify':
        if (checkConnection()) {
            modifyData();
            $response->success = true;
            echo json_encode($response);
        } else {
            $response->error = true;
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
function modifyData()
{

    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "UPDATE listaobjetos SET task='" . $_POST['task'] . "', lenguage='" . $_POST['lenguage'] . "', descripcion='" . $_POST['description'] . "' WHERE id='" . $_POST['id'] . "' ;";
    $conn->query($sql);
}
function getData()
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "SELECT * FROM listaobjetos WHERE id='" . $_POST['id'] . "';";
    $result = $conn->query($sql);
    $task = new stdClass();
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $task->task = $row['task'];
            $task->lenguage = $row['lenguage'];
            $task->descripcion = $row['descripcion'];
            $task->id = $row['id'];
        }
    } else if ($result->num_rows == 0) {
        $task = 'empty';
    } else {
        echo $result->num_rows;
    }
    $conn->close();
    echo json_encode($task);
}
