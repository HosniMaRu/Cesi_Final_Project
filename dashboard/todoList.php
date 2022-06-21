<?php
date_default_timezone_set('Europe/Madrid');
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";

switch ($_POST['api']) {
    case 'add':
        if (checkConnection()) {
            addTableToDDBB();
            echo 'done';
        }
        break;
    default:
        # code...
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
function addTableToDDBB()
{
    $conn = new mysqli('localhost', 'root', '', 'sql4499632');
    $sql = 'CREATE TABLE IF NOT EXISTS posit (email VARCHAR(50) NOT NULL, tarea VARCHAR(30) NOT NULL, lenguaje VARCHAR(30) NOT NULL, descripcion VARCHAR(300) NOT NULL,, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    $conn->close();
}
//  Creacion de usuario.
function addTableDataToDDBB($email, $name, $phone, $password)
{
    $conn = new mysqli('localhost', 'root', '', 'PBD');
    $sql = "INSERT INTO usuarios (email, nombre, phone, password) VALUES ('$email',' $name', '$phone', '" . md5($password) . "');";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "<b>---- CREATE USER ----</b>" . '<br>';
        echo '<b>ID: </b>' . $last_id . '<br>';
        echo "<b>EMAIL: </b>" . $_POST['email'] . '<br>';
        echo "<b>NAME: </b>" . $_POST['name'] . '<br>';
        echo "<b>PHONE: </b>" . $_POST['phone'] . '<br>';
    } else {
        echo 'ERROR: insert table "usuarios"' . $conn->error . '<br>';
    }
    $conn->close();
}
