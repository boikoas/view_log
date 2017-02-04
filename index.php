<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$page = $_GET['page'];
$num = 10;

$dbconn = pg_connect("host=postgres64.1gb.ru port=5432 dbname=xgb_lognmsfdf user=xgb_lognmsfdf password=2298z8ecaxv") or die('Could not connect: ' . pg_last_error());
$qvery = "SELECT COUNT(*) FROM log";
$result = pg_query($dbconn, $qvery);
$row = pg_fetch_assoc($result);
$posts = $row['count'];
$total = intval(($posts - 1) / $num) + 1;
$page = intval($page);
if (empty($page) or $page < 0)
    $page = 1;
if ($page > $total)
    $page = $total;
$start = $page * $num - $num;
// Выбираем $num сообщений начиная с номера $start  
$result = pg_query($dbconn, "SELECT * FROM log LIMIT $num  OFFSET $start");
// В цикле переносим результаты запроса в массив $postrow  
while ($postrow[] = pg_fetch_assoc($result));
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

        <script src="js/script.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link href="css/style.css" rel="stylesheet">

        <title>Test</title>
    </head>
    <body>

        <header class="container">
            <div class="row">
                <h1>Анализатор логов</h1>
            </div>

        </header>
        <section class="container">


            <div class="row">
                <div class="header2 col-lg-12" >
                    <h2>Работа с базой данных:</h2>
                </div>
                <div class="input_databases col-lg-8">
                    <form action="file.php" method="post" id="my_form" enctype="multipart/form-data">
                        <h3>загрузка Лог Файла:</h3>
                        <label for="files">Лог фаил:</label>
                        <input type="file" name="files" id="files"><br>
                        <input type="submit" id="submit" value="Отправить">
                    </form>
                </div>

                <div class="clear_databases col-lg-4">
                    <form action="delete.php" method="post" id="my_form2" enctype="multipart/form-data">
                        <h3>Отчистка базы данных:</h3>
                      
                        <input type="submit" id="submit" value="Отправить">
                    </form>
                </div>
                <div class="header2 col-lg-12" >
                    <h2>Логи:</h2>
                </div>
                <div class="tables ">
                    <table class="table table-hover col-lg-12">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Дата</th>
                                <th>Запрос</th>
                                <th>Ссылка</th>
                                <th>Источник</th>
                                <th>Информация о браузере</th>
                            </tr>
                        <tbody>
                            <?php
                            
                            for ($i = 0; $i < $num; $i++) {
                                echo "<tr> 
                    <td>" . $postrow[$i]['ip'] . "</td> 
                     <td>" . $postrow[$i]['time'] . "</td>".
                    " <td>" . $postrow[$i]['type'] . "</td>".
                    " <td>" . $postrow[$i]['uri'] . "</td>".
                    " <td>" . $postrow[$i]['ref'] . "</td>".
                    " <td>" . $postrow[$i]['agent'] . "</td>".
                     "</tr> ";
                           
                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>

        </section>
        <footer class="container">
            <nav class="row">
                <div class="col-lg-12" >
                    <div class="perexod" >
                        <?php
                        if ($page != 1)
                            $pervpage = '<a href= ./?page=1><<</a>  
                               <a href= ./?page=' . ($page - 1) . '><</a> ';

                        if ($page != $total)
                            $nextpage = ' <a href= ./?page=' . ($page + 1) . '>></a>  
                                   <a href= ./?page=' . $total . '>>></a>';


                        if ($page - 2 > 0)
                            $page2left = ' <a href= ./?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
                        if ($page - 1 > 0)
                            $page1left = '<a href= ./?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';
                        if ($page + 2 <= $total)
                            $page2right = ' | <a href= ./?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
                        if ($page + 1 <= $total)
                            $page1right = ' | <a href= ./?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';


                        echo $pervpage . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $nextpage;
                        ?>
                    </div>
                </div>
            </nav>
        </footer>

    </body>
</html>
