<?php
echo '111111111111111111';
date_default_timezone_set('Europe/Madrid');
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";
$myObj = new stdClass();
switch ($_POST['api']) {
    case "loginUser":
        echo '2222222222222222222222222';
        checkCaptcha(sanitize($_POST['captcha']), $myObj);
        if (isset($myObj->success)) {
            echo '33333333333333333333333333';
            loginUser(sanitize($_POST['email']), sanitize($_POST['password']), $myObj);
        }
        echo json_encode($myObj);
        break;
    case "logOut":
        logOutUser(sanitize($_POST['nombre']), $myObj);
        echo json_encode($myObj);
        break;
    default:
        $myObj->error = "error en el switchCase";
        break;
}
echo '444444444444444444444444444444';
function sanitize($texto)
{
    return htmlentities(strip_tags($texto), ENT_QUOTES, 'UTF-8');
}
function checkCaptcha($captcha, $myObj)
{
    $response = file_GET_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_V3_SECRET_KEY . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
    );
    $response = json_decode($response);
    if ($response->success === false) {
        $myObj->error = "no recaptcha.";
    } else {
        if ($response->success == true && $response->score > 0.5) {
            $myObj->success = true;
        } else if ($response->success == true && $response->score <= 0.5) {
            $myObj->error = "Human?<br>";
        } else {
            $myObj->error = "NO<br>";
        }
    }
}
function loginUser($email, $password, $myObj)
{
    $usuario = new stdClass();
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "SELECT nombre FROM usuarios WHERE email='" . $email . "' && password='" . md5($password) . "' ;";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $usuario->email = $email;
            $usuario->nombre = trim($row['nombre']);
            $usuario->token = md5(time() . "-" . $usuario->email);
            $sql_list = "SELECT id FROM listas WHERE tablename='" . $usuario->nombre . "' ;";
            $resultList = $conn->query($sql_list);
            if ($resultList->num_rows == 1) {
                while ($row = $resultList->fetch_assoc()) {
                    $usuario->id = $row['id'];
                }
            }
            $sql_a = "UPDATE usuarios SET token='" . $usuario->token . "' WHERE email='" . $email . "' ;";
            $result_a = $conn->query($sql_a);
            $myObj->usuario = json_encode($usuario);
            break;
        }
    } else {
        echo "Error: user not found.";
    }
    $conn->close();
}
function logOutUser($nombre, $myObj)
{
    $usuario = new stdClass();
    $conn = new mysqli(MYSQL_SERVER, MYSQL_DDBB, MYSQL_PASSWORD, MYSQL_TABLE);
    $sql = "SELECT * FROM usuarios WHERE nombre='" . $nombre . "' ;";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $usuario->token = $row['token'];
            $usuario->email = $row['email'];
            $usuario->nombre = trim($row['nombre']);
            $myObj->dataUser = $usuario;

            $sql_update = "UPDATE usuarios SET token='' WHERE nombre='" . $nombre . "' ;";
            $conn->query($sql_update);
            break;
        }
    } else {
        echo "Error: user not found.";
    }
    $conn->close();
}
