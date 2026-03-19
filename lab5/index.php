<?php require_once 'classes.php';
/*
Создайте не менее 10 объектов Transaction. Каждая транзакция должна содержать:

разные даты;
разные суммы;
разные описания;
разных получателей.
После создания объектов добавьте транзакции в TransactionRepository.

private int $id,private string $date ,
private float $amount 
        ,private  string $description,
        private string $merchant  
*/

$transactionArr = [];

$transactionArr = [

    new Transaction(1, "2019-01-01", 100.00, "Купили что то там", "торговец_1"),
    new Transaction(2, "2019-01-03", 45.50, "Купили что то тут", "торговец_2"),
    new Transaction(3, "2019-01-15", 230.00, "Стрижечка", "торговец_1"),
    new Transaction(4, "2019-01-07", 32.99, "Купили кофеек", "торговец_3"),
    new Transaction(5, "2019-01-10", 75.25, "Игры на стим", "торговец_2"),
    new Transaction(6, "2019-01-12", 140.99, "Купили гпт плюс", "торговец_4"),
    new Transaction(7, "2019-01-15", 150.00, "Счета за газ", "торговец_3"),
    new Transaction(8, "2019-01-12", 160.40, "Книжечкиииии", "торговец_5"),
    new Transaction(9, "2019-01-20", 89.90, "Поели шавы", "торговец_1"),
    new Transaction(10, "2019-01-05", 34.75, "Запили шаву", "торговец_4")
];

$transastRepository = new TransactionRepository();

foreach($transactionArr as $transaction)
{
    $transastRepository->addTransaction($transaction);
}

$transactionRenderer = new TransactionTableRenderer();

?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Транзакции</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php 
        echo $transactionRenderer->render($transastRepository->getAllTransactions());
    ?>
</body>
</html>

