<?php

declare(strict_types=1);




$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Купили что то там",
        "merchant" => "торговец1",
    ],
    [
        "id" => 2,
        "date" => "2019-01-03",
        "amount" => 45.50,
        "description" => "Купили что то тут",
        "merchant" => "торговец2",
    ],
    [
        "id" => 3,
        "date" => "2019-01-15",
        "amount" => 230.00,
        "description" => "Стрижечка",
        "merchant" => "торговец1",
    ],
    [
        "id" => 4,
        "date" => "2019-01-07",
        "amount" => 32.99,
        "description" => "Купили кофеек",
        "merchant" => "торговец3",
    ],
    [
        "id" => 5,
        "date" => "2019-01-10",
        "amount" => 75.25,
        "description" => "Игры на стим",
        "merchant" => "торговец2",
    ],
    [
        "id" => 6,
        "date" => "2019-01-12",
        "amount" => 140.99,
        "description" => "Купили пгт плюс",
        "merchant" => "торговец4",
    ],
    [
        "id" => 7,
        "date" => "2019-01-15",
        "amount" => 150.00,
        "description" => "Счета за газ",
        "merchant" => "торговец3",
    ],
    [
        "id" => 8,
        "date" => "2019-01-12",
        "amount" => 160.40,
        "description" => "Книжечкиииии",
        "merchant" => "торговец5",
    ],
    [
        "id" => 9,
        "date" => "2019-01-20",
        "amount" => 89.90,
        "description" => "Поели шавы",
        "merchant" => "торговец1",
    ],
    [
        "id" => 10,
        "date" => "2019-01-05",
        "amount" => 34.75,
        "description" => "Запили шаву",
        "merchant" => "торговец4",
    ]
];


$tz = ini_get('date.timezone');
$dtz = new DateTimeZone($tz);

/**
 * Вычисляет общую сумму всех транзакций
 *
 * @param array $transactions массив транзакций
 * @return float
 */
function calculateTotalAmount(array $transactions): float
{
    $totalAmount = 0;
    foreach ($transactions as $array) {
        $totalAmount += $array['amount'];
    }
    return $totalAmount;
}

/**
 * Ищет транзакцию по части описания
 *
 * @param string $descriptionPart -описание транзакции
 * @return array массив с транзакциями, которые подходят под описание
 */
function findTransactionByDescription(string $descriptionPart): array
{
    global $transactions;
    $suitableTransactions = [];
    foreach ($transactions as $arr) {
        if (strpos($arr['description'], $descriptionPart) !== false) {
            $suitableTransactions[] =  $arr;
        }
    }
    return $suitableTransactions;
}

/**
 * Ищет транзакцию по идентификатору
 *
 * @param int $id -id транзакции 
 * @return array - транзакция, имеющая указаный id или null, если такой транзакции не найденно.
 */
function findTransactionById(int $id): ?array
{
    global $transactions;

    foreach ($transactions as $arr) {
        if ($arr['id'] == $id) {
            return $arr;
        }
    }
    return null;
}
/**
 * Возвращает количество дней между датой транзакции и текущим днем
 *
 * @param int $trnsactionId -id транзакции 
 * @return int - количество дней, прошедших с даты транзакции
 */
function daysSinceTransaction(int $trnsactionId): ?int
{
    global $dtz, $transactions;
    $currentDate = new DateTime('now', $dtz);

    foreach ($transactions as $arr) {
        if ($arr['id'] == $trnsactionId) {
            $passedDate = new DateTime($arr['date'], $dtz);
            return $passedDate->diff($currentDate)->days;
        }
    }
    return null;
}
/**
 * Добавляет новую транзакцию в массив
 *
 * @param int $id -id транзакции 
 * @param string $date -дата  транзакции 
 * @param float $amount -сумма  транзакции 
 * @param string $description -описание  транзакции 
 * @param string $merchant -продавец 
 * @return void 
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void
{
    global $transactions;
    foreach ($transactions as $arr) {
        if ($arr['id'] == $id) {
            echo "Транзакция с таким id уже существует";
            return;
        }
    }
    $transactions[] = [
        'id' => $id,
        'date' => $date,
        'amount' => $amount,
        'description' => $description,
        'merchant' => $merchant,
    ];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTrid = (int)$_POST['id'];
    $newTrDate = $_POST['date'];
    $newTrAmount = (float)$_POST['amount'];
    $newTrdescr = $_POST['description'];
    $newTrMerch = $_POST['merchant'];

    addTransaction($newTrid, $newTrDate, $newTrAmount,  $newTrdescr, $newTrMerch);
}

/**
 * Вспомогательная функция для сортировки, сравнивает даты двух транзакций.
 *
 * @param array $a - первая транзакция для сравнения 
 * @param array $b - вторая транзакция для сравнения 
 * @return int - 1 = если дата первой транзакции больше, -1 = если дата второй транзакции больше, 0 = если даты идентичны 
 */
function usortDate($a, $b): int
{
    global $tz;
    $firstdate = new dateTime($a['date']);
    $secdate = new DateTime($b['date']);

    if ($firstdate > $secdate) {
        return 1;
    } elseif ($secdate > $firstdate) {
        return -1;
    }
    return 0;
}

/**
 * Вспомогательная функция для сортировки, сравнивает суммы двух транзакций.
 *
 * @param array $a - первая транзакция для сравнения 
 * @param array $b - вторая транзакция для сравнения 
 * @return int - 1 = если сумма первой транзакции больше, -1 = если сумма второй транзакции больше, 0 = если суммы идентичны 
 */
function usortAmount($a, $b): int
{
    if ($a['amount'] > $b['amount']) {
        return 1;
    } elseif ($b['amount'] > $a['amount']) {
        return -1;
    }
    return 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>
    <h3 class="headerStyle">Тот, кто придумал вот так выводить элементы в таблицу, особенный.</h3>
    <table border='1'>
        <tr>
            <?php
            foreach ($transactions[0] as $key => $value) { ?>
                <th>
                    <?php echo " " . $key; ?>
                </th>
            <?php
            }
            ?>
            <th>Date difference
            </th>
        </tr>
        <?php foreach ($transactions as $el) { ?>
            <tr>

                <?php foreach ($el as $key => $value) { ?>
                    <th>
                        <?php echo " " . $value; ?>
                    </th>
                <?php
                }
                ?>
                <th>
                    <?php
                    echo daysSinceTransaction($el['id']);
                    ?>
                </th>

            </tr>
        <?php
        }
        ?>
        <tr>
            <th colspan="<?php
                            echo count($transactions[0]) + 1;

                            ?>">

                <?php
                echo "Total Amount: " . calculateTotalAmount($transactions);
                ?>
            </th>
        </tr>
    </table>

    <hr />
    <br />
    <h3 class="headerStyle">
        findTransactionByDescription
    </h3>
    <table>
        <tr>
            <th> Id</th>
            <th> Description</th>
        </tr>
        <?php
        foreach (findTransactionByDescription("Купили") as $trans) {
        ?>
            <tr>
                <th>
                    <?php
                    echo " " . $trans['id'];
                    ?>
                </th>
                <th>
                    <?php
                    echo " " . $trans['description'];
                    ?>
                </th>
            </tr>
        <?php
        }
        ?>
    </table>

    <h3>
        findTransactionById Пример: 4
    </h3>
    <h4>
        <?php
        $trans = findTransactionById(4);
        echo "Транзакция с id: " . $trans['description'] . "  Стоимость:" . $trans['amount'];
        ?>
    </h4>
    <br />
    <hr />
    <h3>Add new transaction</h3>

    <form method="post" class="transaction-form">

        <label>ID</label>
        <input type="number" name="id" required>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" required>

        <label>Description</label>
        <input type="text" name="description" required>

        <label>Merchant</label>
        <input type="text" name="merchant" required>

        <button type="submit">Add Transaction</button>

    </form>


    <h3 class="headerStyle">Сортировка транзакций по дате (в гробу я видала такую запись) </h3>
    <?php
    usort($transactions, 'usortDate');
    ?>
    <table border='1'>
        <tr>
            <?php
            foreach ($transactions[0] as $key => $value) { ?>
                <th>
                    <?php echo " " . $key; ?>
                </th>
            <?php
            }
            ?>
        </tr>
        <?php foreach ($transactions as $el) { ?>
            <tr>

                <?php foreach ($el as $key => $value) { ?>
                    <th>
                        <?php echo " " . $value; ?>
                    </th>
                <?php
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </table>

    <h3 class="headerStyle">Сортировка транзакций по сумме </h3>

    <?php
    usort($transactions, 'usortAmount');
    ?>
    <table border='1'>
        <tr>
            <?php
            foreach ($transactions[0] as $key => $value) { ?>
                <th>
                    <?php echo " " . $key; ?>
                </th>
            <?php
            }
            ?>
        </tr>
        <?php foreach ($transactions as $el) { ?>
            <tr>

                <?php foreach ($el as $key => $value) { ?>
                    <th>
                        <?php echo " " . $value; ?>
                    </th>
                <?php
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </table>
    <br />

    </body>

</html>