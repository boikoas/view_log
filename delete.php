<?php

if (isset($_POST['submit'])){
    $req = false; // изначально переменная для "ответа" - false
    // Приведём полученную информацию в удобочитаемый вид
    ob_start();
    echo '<pre>';
    $dbconn = pg_connect("host=postgres64.1gb.ru port=5432 dbname=xgb_lognmsfdf user=xgb_lognmsfdf password=2298z8ecaxv")  or die('Could not connect: ' . pg_last_error());   
    $qvery = "DELETE FROM log";
    $result = pg_query($dbconn, $qvery); 
    if($result){
        echo ('База пуста');
    }else{
         echo ('Ошибка при удаление');
    }
    
  
    echo '</pre>';

    $req = ob_get_contents();
    ob_end_clean();
    
    pg_close($dbconn);
    echo json_encode($req); // вернем полученное в ответе
}
