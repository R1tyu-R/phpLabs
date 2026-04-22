<?php

$days = 288;
$message = "Все возвращаются на работу!";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Моя страница</title>


    <style type="text/css">
        h3 {
            color: crimson;
        }
    </style>
</head>

<body>
    <h3>
        <?php

        echo  " Никита, я старалась! надюсь все лабы будут такими же простыми";?>

    </h3>
    <?php

    echo "Привет мир!";?>
    <br />
    <?php
    echo "Немного вывода данных";?>
    <br />
    <?php
    print("А тут выводим с помощью printa")?>
    <br />
    <?php

    echo "Тут мы используем конкатенацию: days = " . $days;?>
    <br />
    <?php

    echo "Тут мы используем Интерполяцию строк, (слишком умные слова) : {$message}";?>
</body>
</html>