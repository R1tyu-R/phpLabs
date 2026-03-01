<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #7f96ad;
            margin: 0;
            text-align: center;
        }

        table {
            margin: 40px auto;
            border-collapse: collapse;
            width: 800px;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #516b85;
            color: white;
        }

        h2 {
            margin-top: 40px;
            color: white;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px auto;
            width: 800px;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        li:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <?php
    date_default_timezone_set('Europe/Chisinau');
    $date = date("N");
    $worcableDay =  [[1, 3, 5], [2, 4, 6]];
    function workableDate(int $num): string
    {
        global $date;
        global $worcableDay;
        if (!in_array($date, $worcableDay[$num])) {
            return "Нерабочий день";
        } else {
            return $num = 0 ? "8:00-12:00" : "12:00-16:00";
        }
    }
    ?>

    <h2>Условные конструкции</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Фамилия Имя</th>
            <th>график работы</th>
        </tr>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td>
                <?php
                echo workableDate(0);
                ?>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td>
                <?php
                echo workableDate(1);
                ?>
            </td>
        </tr>
    </table>

    </br>

    <h2>Цикл for </h2>

    <?php
    $a = 0;
    $b = 0;
    $iteration = 0;

    function setDefault()
    {
        return [0,0,0];
    }
    ?>
    <ul>
        <?php
        for ($i = 0; $i <= 5; $i++) {
            $a += 10;
            $b += 5; ?>
            <li>
                <?php echo "a: " . $a . " b: " . $b; ?>
            </li>
        <?php
        }
        ?>
    </ul>
    <p>
        <?php
        echo "End of the loop: a = $a, b = $b";
        ?>
    </p>
    <h2>Цикл while </h2>

    <ul>
        <?php
        [$a,$b,$iteration] = setDefault();
        while ( $iteration <= 5) 
        {
            $a += 10;
            $b += 5; 
            $iteration++;   ?>
            <li>
                <?php echo "a: " . $a . " b: " . $b; ?>
            </li>
        <?php
        }
        
        ?>
    </ul>
    <p>
        <?php
        echo "End of the loop: a = $a, b = $b";
        ?>
    </p>

    <h2>Цикл do while </h2>

    
    <ul>
        <?php
        [$a,$b,$iteration] = setDefault();
        do
        {
            $a += 10;
            $b += 5; 
            $iteration++;   ?>
            <li>
                <?php echo "a: " . $a . " b: " . $b; ?>
            </li>
        <?php
        }while ( $iteration <= 5) ;
        ?>
    </ul>
    <p>
        <?php
        echo "End of the loop: a = $a, b = $b";
        ?>
    </p>

</body>

</html>