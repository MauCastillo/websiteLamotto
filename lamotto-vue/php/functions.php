<?php
// Set your Bot ID and Chat ID.
$telegrambot='1334271256:AAF86zdJ9MmGjvcVPWEWJbNReFxK4DttgFU';
$telegramchatid=374659345;

$dataPost = file_get_contents('php://input');
$variablePost = json_decode($dataPost, true);

if (isset($variablePost["function"]) and isset($variablePost["parametros"])) {
    $function = $variablePost["function"];
    $parametros = $variablePost["parametros"];
} else{
    echo json_encode([
        'message' => 'function no found',
        'status' => false,
        'data' => $dataPost,
        'function' => $function,
        'params' => $parametros
    ]);

    return;
}


if (function_exists($function)) {
    $function($parametros);
}

// get_nearby_test_center Get long list of posts and articles
function set_record_user($parametros)
{
    if (isset($parametros["name"])) {
        $name = $parametros["name"];
    } else {
        echo json_encode(['message' => 'Empty null id in name', 'status' => $parametros["name"], ]);
        return;
    }

    if (isset($parametros["lastname"])) {
        $lastname = $parametros["lastname"];
    } else {
        echo json_encode(['message' => 'Empty null id in lastname', 'status' => $parametros["lastname"], ]);
        return;
    }

    if (isset($parametros["phone"])) {
        $phone = $parametros["phone"];
    } else {
        echo json_encode(['message' => 'Empty null id in phone', 'status' => $parametros["phone"], ]);
        return;
    }

    if (isset($parametros["identification"])) {
        $identifiaction = $parametros["identification"];
    } else {
        echo json_encode(['message' => 'Empty null id in identifiaction', 'status' => $parametros["identification"], ]);
        return;
    }


    if (isset($parametros["placa"])) {
        $placa = $parametros["placa"];
    } else {
        echo json_encode(['message' => 'Empty null id in placa', 'status' => $parametros["placa"], ]);
        return;
    }

    if (isset($parametros["email"])) {
        $email = $parametros["email"];
    } else {
        echo json_encode(['message' => 'Empty null id in email', 'status' => $parametros["email"], ]);
        return;
    }

    include_once 'connection.php';
    $query = "INSERT INTO `reports_user`(`name`, `lastname`, `phone`, `identification`, `placa`, `email`) VALUES ('$name','$lastname','$phone','$identifiaction','$placa', '$email');";

    $stmt = $mysqli->prepare($query) or die(json_encode(['status' => 'danger', 'message' => $mysqli->error]));
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    echo json_encode(['status' => 'success', 'message' => 'Success! insert in database']);
    return;
}

function get_record_user($parametros)
{
    include_once 'connection.php';
    $query = "SELECT `id`, `name`, `lastname`, `phone`, `identification`, `placa`, `email`, `date` FROM `reports_user`;";

    $stmt = $mysqli->prepare($query)or die(json_encode(['status' => 'danger', 'message' => $mysqli->error]));
    $stmt->execute();
    $return = array();
    $result = $stmt->get_result();
    foreach($result as $key => $res) {
        $return[$key]['id'] = $res['id'];
        $return[$key]['name'] = $res['name'];
        $return[$key]['lastname'] = $res['lastname'];
        $return[$key]['phone'] = $res['phone'];
        $return[$key]['identification'] = $res['identification'];
        $return[$key]['placa'] = $res['placa'];
        $return[$key]['email'] = $res['email'];
        $return[$key]['date'] = $res['date'];
    }

    $stmt->close();
    echo json_encode($return);
    send_email();
    return;
}

function send_email(){
    

// Pear Mail Library
require_once "Mail.php";

$from = 'usuariolamottoco@gmail.com';
$to = 'mauroatm@gmail.com';
$subject = 'Hi!';
$body = "Hi,\n\nHow are you?";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'usuariolamottoco@gmail.com',
        'password' => 'UbZ@$st$Lvba&3'
    ));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}


}

?>