<?php
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

    if (isset($parametros["link"])) {
        $url = $parametros["link"];
    } else {
        echo json_encode(['message' => 'Empty null id in url', 'status' => 'error']);
        return;
    }

    include_once 'connection.php';
    $query = "INSERT INTO `reports_user`(`name`, `lastname`, `phone`, `identification`, `placa`, `email`) VALUES ('$name','$lastname','$phone','$identifiaction','$placa', '$email');";

    $stmt = $mysqli->prepare($query) or die(json_encode(['status' => 'danger', 'message' => $mysqli->error]));
    $stmt->execute();
    
    $query = "SELECT LAST_INSERT_ID() AS id;";
    $result = $mysqli->query($query);
    $user_ID = null;
    foreach($result as $key => $res) {
        $user_ID = $res['id'];
    }
  
    $stmt->close();
    $UserIDencryption = encryption($user_ID);
    echo json_encode(['status' => 'success', 'message' => 'Success! insert in database', 'user_id' => send_msj("La Motto => Nuevo Usuario Registrado $name $lastname link: $url=$UserIDencryption")]);
    return;
}

function get_record_user($parametros)
{
    include_once 'connection.php';
    $query = "SELECT `id`, `name`, `lastname`, `phone`, `identification`, `placa`, `email`, `date` FROM `reports_user`;";
    $result = $mysqli->query($query);
    $return = array();
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
    echo json_encode($return);
    return;
}

function get_user($parametros)
{
    if (isset($parametros["ID"])) {
        $user_id = $parametros["ID"];
      } else {
          echo json_encode(['message' => 'Empty null id in ID', 'status' => $parametros["ID"], ]);
          return;
      }
    
    $user_id =  dencryption($user_id);
    include_once 'connection.php';
    $query = "SELECT `id`, `name`, `lastname`, `phone`, `identification`, `placa`, `email`, `date` FROM `reports_user` WHERE id = $user_id;";
    $result = $mysqli->query($query);
    $return = array();
    foreach($result as $key => $res) {
        $return[$key]['id'] = $res['id'];
        $return[$key]['name'] = $res['name'];
        $return[$key]['lastname'] = $res['lastname'];
        $return[$key]['phone'] = $res['phone'];
        $return[$key]['identification'] = $res['identification'];
        $return[$key]['placa'] = $res['placa'];
        $return[$key]['email'] = $res['email'];
        $return[$key]['date'] = $res['date'];
        $return[$key]['IDEC'] = $user_id;
        
    }
    echo json_encode($return);
    return;
}

function send_msj($msj) {
    $MesssajeEncode = str_replace(' ', '%20', $msj);
    $WHATSAPP_CLIENT='+570000000000';
    $WHATSAPP_FROM='+120000000000';        
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.twilio.com/2010-04-01/Accounts/ACa2cdfecf14d138aca0171d480830eda0/Messages?To=$WHATSAPP_CLIENT&From=$WHATSAPP_FROM&Body=$MesssajeEncode",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "To=$WHATSAPP_CLIENT&From=$WHATSAPP_FROM&Body=$MesssajeEncode",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic <Token HERE>",
        "Content-Type: application/x-www-form-urlencoded"
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

function encryption($simple_string){     
    include 'security.php';
    $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv); 
    
    return $encryption; 
}

function dencryption($encryption) {     
    include 'security.php';   
    $decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv); 
  
    return $decryption; 
}


?>