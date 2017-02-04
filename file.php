<?php

function __autoload($class) {
    require_once "reader.php";
}
   
if (isset($_FILES['files'])) {
   $dbconn = pg_connect("host=postgres64.1gb.ru port=5432 dbname=xgb_lognmsfdf user=xgb_lognmsfdf password=2298z8ecaxv")  or die('Could not connect: ' . pg_last_error());   
    $req = false; // изначально переменная для "ответа" - false
    // Приведём полученную информацию в удобочитаемый вид
    ob_start();
    echo '<pre>';
    $uploadfile = "temp/" . $_FILES['files']['name'];
    if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
        echo "Фаил считан";
        $stream = new FileReader($uploadfile);
        $iss = $stream->Read();
           foreach ($iss as $value) {
            $log = array();
            sscanf(trim($value), '%s %s %s [%s  %s "%s %s %s %s %s "%s "%s"', $log ['ip'], $log ['client'], $log ['user'], $log ['time'], $log ['method'], $log ['method2'], $log ['uri'], $log ['prot'], $log ['code'], $log ['bytes'], $log ['ref'], $log ['agent']);
            $log ['agent'] = substr(strstr($value, $log ['agent']), 0, -1);
              $log ['ref'] = substr($log ['ref'], 0, -1);
              $log ['ref'] = substr($log ['ref'], 0, -1);
              $log ['prot'] = substr($log ['prot'], 0, -1);
              //$log ['agent']=base64_encode( $log ['agent']);
              $qvery2=
                    "'" . 
                    $log ['ip'].
                     "','".
                    $log ['time'].
                     "','".
                    $log ['method2'].
                    "','".
                    $log ['uri'].
                   "','".
                    $log ['ref'].
                    "','".
                    $log ['agent'].
                       "'";
              $qvery = "INSERT INTO log (ip, time, type, uri, ref, agent) VALUES (".$qvery2.");";
              $qvery.'<br>';
             $result = pg_query($dbconn, $qvery);
          
        }
          } else {
        echo "Ошибка чтения файла";
    }
    echo '</pre>';

    $req = ob_get_contents();
    ob_end_clean();
    pg_close($dbconn);
    echo json_encode($req); // вернем полученное в ответе
    exit;
}

 



