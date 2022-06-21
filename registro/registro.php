<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/admin.php";
date_default_timezone_set('Europe/Madrid');
$myObj = new stdClass();

switch ($_POST['action']) {
    case 'checkEmail':
        $email = sanitize($_POST['email']);
        checkEmail($email, $myObj);
        if (isset($myObj->success)) {
            validateCaptcha($email, sanitize($_POST['name']), sanitize($_POST['phone']), sanitize($_POST['password']), sanitize($_POST['captcha']), $myObj);
        }
        echo json_encode($myObj);
        break;
    default:
        $myObj->error = "Error en el action";
        echo json_encode($myObj);
        break;
}
function checkEmail($email, $myObj)
{
    $email = strtolower(str_replace(" ", "", trim($email)));
    if ($email == "" || is_numeric($email)) {
        $myObj->error = "Please insert a correct email.";
        exit;
    }
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_USER);
    $sql = "SELECT email FROM usuarios_temp WHERE email='" . trim($email) . "' ;";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $myObj->error = 'Already exist: ' . $row['email'];
        }
    } else {
        $myObj->success = "email is correct";
    }
    $conn->close();
}
function validateCaptcha($email, $name, $phone, $password, $captcha, $myObj)
{
    $response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_V3_SECRET_KEY . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
    );
    $response = json_decode($response);
    if ($response->success === false) {
        echo $response->success;
    } else {
        if ($response->success == true && $response->score > 0.5) {
            saveDDBB(sanitize(trim($email)), sanitize(trim($name)), sanitize(trim($phone)), sanitize(trim($password)), $myObj);
        } else if ($response->success == true && $response->score <= 0.5) {
            echo "Human?<br>";
        } else {
            echo "NO<br>";
        }
    }
}
function saveDDBB($email, $name, $phone, $password, $myObj)
{
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_USER);
    $sql = "INSERT INTO usuarios_temp (email, nombre, phone, password) VALUES ('$email',' $name', '$phone', '" . md5($password) . "');";
    if ($conn->query($sql) === TRUE) {
        userToken($email, $myObj);
        $myObj->success = "Usuario guardado en la BBDD";
    } else {
        $myObj->success = "Usuario guardado en la BBDD";
    }
    $conn->close();
}
function userToken($email, $myObj)
{
    $usuario = new stdClass();
    $conn = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_USER);
    $sql = "SELECT  * FROM usuarios_temp WHERE email='" . $email . "' LIMIT 1;";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $usuario->email = $row['email'];
            $usuario->name = $row['nombre'];
            $usuario->phone = $row['phone'];
            $usuario->password = $row['password'];
            $usuario->reg_date = $row['reg_date'];
            $usuario->id = $row['id'];
        }
        $xstring = $usuario->id . "-" . $usuario->email . "-" . $usuario->name . "-" . $usuario->phone . "-" . $usuario->password . "-" . $usuario->reg_date;
        $token_user = sha1($xstring);
        $token_user;
        $myObj->userToken = $token_user;
        sendMail($usuario, $token_user, $myObj);
    } else {
        echo 'asd';
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($usuario, $token_user, $myObj)
{
    $HostSMTP = 'smtp.gmail.com';
    $ContrasenaDelCorreo = 'oosnbszczvcuueyo';
    $SendFromEMAIL = 'hosni.marco@gmail.com';
    $QuienLoEnviaNAME = 'moderator';
    $SendFromEMAILreply = 'hosni.marco@gmail.com';
    $QuienResponderNAME = 'moderator';
    $PortSMTP = 465;

    $SentToEmail = $usuario->email;
    $Asunto = "ninguno";
    $BodyHTML = "<h1>Bienvenido al TODO LIST " . $usuario->name . " Hax click en el link para loguearte." . "</h1><br><a href='http://" . $_SERVER['HTTP_HOST'] . "/registro/new_user.php?id=" . $usuario->id . "&clave=" . $token_user . "'><b>" . $token_user . "</b></a>";
    $BodyNOHTML = "hola que tal?";

    require realpath($_SERVER["DOCUMENT_ROOT"]) . '/vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = $HostSMTP;
        $mail->SMTPAuth   = true;
        $mail->Username   = $SendFromEMAIL;
        $mail->Password   = $ContrasenaDelCorreo;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $PortSMTP;

        $mail->setFrom($SendFromEMAIL, $QuienLoEnviaNAME);
        $mail->addAddress($SentToEmail);
        $mail->addReplyTo($SendFromEMAIL, $QuienLoEnviaNAME);
        $mail->isHTML(true);
        $mail->Subject = $Asunto;
        $mail->Body    = $BodyHTML;
        $mail->AltBody = $BodyNOHTML;

        $mail->send();
        $myObj->sendEmail =  'Message has been sent';
    } catch (Exception $e) {
        $myObj->sendEmail =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sanitize($text)
{
    return htmlentities(strip_tags($text), ENT_QUOTES, 'UTF-8');
}
