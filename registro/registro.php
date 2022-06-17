<?php
// mysqli('sql4.freemysqlhosting.net', 'sql4499632', 'SqpEq4ZEvZ', 'sql4499632');

date_default_timezone_set('Europe/Madrid');
define("RECAPTCHA_V3_SECRET_KEY", '6LemHlMgAAAAAL9dq7CKAZhtH-VGp_-460Em0rQU');
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
    $conn = new mysqli("sql4.freemysqlhosting.net", "sql4499632", "SqpEq4ZEvZ", "sql4499632");
    $sql = "SELECT email FROM usuarios_temp WHERE email='" . $email . "' ;";
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
        //Do something with error
    } else {
        if ($response->success == true && $response->score > 0.5) {
            saveDDBB($email, $name, $phone, $password, $myObj);
        } else if ($response->success == true && $response->score <= 0.5) {
            echo "Human?<br>";
        } else {
            echo "NO<br>";
        }
    }
}
function saveDDBB($email, $name, $phone, $password, $myObj)
{
    $conn = new mysqli('sql4.freemysqlhosting.net', 'sql4499632', 'SqpEq4ZEvZ', 'sql4499632');
    $sql = "INSERT INTO usuarios_temp (email, nombre, phone, password) VALUES ('$email',' $name', '$phone', '" . md5($password) . "');";
    if ($conn->query($sql) === TRUE) {
        // $last_id = $conn->insert_id;
        userToken($email, $myObj);
        $myObj->success = "Usuario guardado en la BBDD";
    } else {
        $myObj->success = "Usuario guardado en la BBDD";
        // echo 'ERROR: insert table "usuarios"' . $conn->error . '<br>';
    }
    $conn->close();
}
function userToken($email, $myObj)
{
    $usuario = new stdClass();
    $conn = new mysqli('sql4.freemysqlhosting.net', 'sql4499632', 'SqpEq4ZEvZ', 'sql4499632');
    $sql = "SELECT  * FROM usuarios_temp WHERE email='" . $email . "' LIMIT 1;"; // ORDER BY reg_date ASC LIMIT 1
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
    // $conn->close();
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($usuario, $token_user, $myObj)
{
    //MAIL
    $HostSMTP = 'smtp.gmail.com'; // Set the SMTP server to send through
    $ContrasenaDelCorreo = 'oosnbszczvcuueyo'; // SMTP password
    $SendFromEMAIL = 'hosni.marco@gmail.com'; // SMTP username
    $QuienLoEnviaNAME = 'moderator';
    $SendFromEMAILreply = 'hosni.marco@gmail.com';
    $QuienResponderNAME = 'moderator';
    $PortSMTP = 465; // TCP port to connect to
    //$PortSMTP = 587; // TCP port to connect to
    //
    $SentToEmail = $usuario->email;
    $Asunto = "ninguno";
    $BodyHTML = "<h1>Bienvenido al TODO LIST " . $usuario->name . " Hax click en el link para loguearte." . "</h1><br><a href='http://" . $_SERVER['HTTP_HOST'] . "/AJAX/registro_php/new_user.php?id=" . $usuario->id . "&clave=" . $token_user . "'><b>" . $token_user . "</b></a>";
    $BodyNOHTML = "hola que tal?";

    //Load Composer's autoloader
    require realpath($_SERVER["DOCUMENT_ROOT"]) . '/vendor/autoload.php';

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_CONNECTION;                      //Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $HostSMTP;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $SendFromEMAIL;                     //SMTP username
        $mail->Password   = $ContrasenaDelCorreo;                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $PortSMTP;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($SendFromEMAIL, $QuienLoEnviaNAME);
        //$mail->addAddress($SentToEmail, 'Joe User');     //Add a recipient
        $mail->addAddress($SentToEmail);               //Name is optional
        $mail->addReplyTo($SendFromEMAIL, $QuienLoEnviaNAME);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
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
