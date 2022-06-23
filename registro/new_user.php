<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";

if (isset($_GET['id']) && isset($_GET['clave'])) {
    $id = $_GET['id'];
    $clave = $_GET['clave'];
    $usuario = new stdClass();
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "SELECT * FROM usuarios_temp WHERE id='" . $id . "' ;";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $usuario->id = $row['id'];
            $usuario->email = $row['email'];
            $usuario->nombre = trim($row['nombre']);
            $usuario->phone = $row['phone'];
            $usuario->password = $row['password'];
            $usuario->reg_date = $row['reg_date'];
        }
        $xstring = $usuario->id . "-" . $usuario->email . "-" . $usuario->nombre . "-" . $usuario->phone . "-" . $usuario->password . "-" . $usuario->reg_date;
        $sha1 = sha1($xstring);
        echo '<br>clave: ' . $clave;
        echo '<br>clave sha: ' . $sha1;
        if ($clave == $sha1) {
            insertUser($usuario);
        }
    } else {
        echo "Error: id not found.";
    }
    $conn->close();
}

function insertUser($user)
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "INSERT INTO usuarios ( email,nombre,phone,password,reg_date) VALUES ('" . $user->email . "','" . sanitize($user->nombre) . "'," . $user->phone . ",'" . $user->password . "','" . date("Y-m-d H:i:s") . "');";
    if ($conn->query($sql) === TRUE) {
        echo "<br>OK";
        $sql_a = "DELETE FROM usuarios_temp WHERE email='" . $user->email . "' || reg_date <= NOW() - INTERVAL 1 DAY;";
        $conn->query($sql_a);
        $sql_id = "SELECT id FROM usuarios WHERE email='" . $user->email . "';";
        $result = $conn->query($sql_id);
        $usuario = new stdClass();
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $usuario->id = $row['id'];
            }
            insertListTable($usuario->id, $user->nombre);
        }
        header('Location: ../login/login.html');
    } else {
        echo "<br>ERROR";
    }
    $conn->close();
}

function sanitize($text)
{
    return htmlentities(strip_tags($text), ENT_QUOTES, 'UTF-8');
}
function insertListTable($idUser, $name)
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = 'INSERT INTO listas (iduser, tablename) VALUES ("' . $idUser . '","' . $name . '");';
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    $conn->close();
}
