# Лабораторная работа №5. Объектно-ориентированное программирование в PHP

- Выполнил студент: Борисенко Дарья
- Группа: IA2403
- Преподоватерь: Нартя Никита

## Цель работы 
Освоить основы объектно-ориентированного программирования в PHP на практике. Научиться создавать собственные классы, использовать инкапсуляцию для защиты данных, разделять ответственность между классами, а также применять интерфейсы для построения гибкой архитектуры приложения.

## Задание 1 Класс Transaction
Создаем класс `Transaction`, который описывает одну банковскую транзакцию.

Со следующей структурой: 
- `id` — уникальный идентификатор транзакции;
- `date` — дата транзакции;
- `amount` — сумма транзакции;
- `description` — описание платежа;
- `merchant` — получатель платежа.

**Метод класса :**

`getDaysSinceTransaction(): int` - который возвращает количество дней с момента транзакции до текущей даты.

Все поля приватны. Для получения данных из приватных полей созданы геттеры.

```php
    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    
    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMerchant(): string
    {
        return $this->merchant;
    }
```

## Задание 2 Класс TransactionRepository
Создаем класс TransactionRepository, который будет управлять коллекцией транзакций. 

Класс хранить массив объектов Transaction

Имеет следующие методы: 

- `addTransaction(Transaction $transaction): void` - добавляет новые транзакции
- `removeTransactionById(int $id): void` - удаляет транзакции по идентификатору
- `getAllTransactions(): array` - возвращает полный список транзакций
- `findById(int $id): ?Transaction` - находит транзакцию по id

Доступ к данным осуществляется только через методы класса

```php
public function addTransaction(Transaction $transaction): void
{
    $this->transactions[] = $transaction;
}

public function removeTransactionById(int $id): void
{
    foreach ($this->transactions as $num => $transaction) {
        if ($transaction->getId() === $id) {
            unset($this->transactions[$num]);
        }
    }
}
    
public function getAllTransactions(): array
{
    return $this->transactions;
}

public function findById(int $id): ?Transaction
{
    foreach ($this->transactions as $transaction) {
        if ($transaction->getId() === $id) {
            return $transaction;
        }
    }
    return null;
}
```

## Задание 3 Класс TransactionManager

Класс TransactionManager, использует TransactionRepository для выполнения бизнес-логики.

Имеет следующие методы: 
- `calculateTotalAmount(): float` - вычисляет общую сумму всех транзакций
- `calculateTotalAmountByDateRange(string $startDate, string $endDate): float` - вычисляет сумму транзакций за определенный период
- `countTransactionsByMerchant(string $merchant): int` - считает количество транзакций по определенному получателю
- `sortTransactionsByDate(): Transaction[]` - сортирует транзакции по дате
- `sortTransactionsByAmountDesc(): Transaction[]` - сортирует транзакции по сумме по убыванию

```php
public function calculateTotalAmount(): float
{
    $totalAmount = 0;
    foreach ($this->repository->getAllTransactions() as $transaction) {
        $totalAmount += $transaction->getAmount();
    }
    return $totalAmount;
}

public function calculateTotalAmountByDateRange(string $startDate, string $endDate): float
{
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);
    $totalAmount = 0;
    foreach ($this->repository->getAllTransactions() as $transaction) {
        $transactionDate = new DateTime($transaction->getDate());
        if ($transactionDate >= $startDate && $transactionDate <= $endDate) {
            $totalAmount += $transaction->getAmount();
        }
    }
    return $totalAmount;
}

public function countTransactionsByMerchant(string $merchant): int
{
    $numOfMerchantTransactions = 0;
    foreach ($this->repository->getAllTransactions() as $transaction) {
        if ($transaction->getMerchant() === $merchant) {
            $numOfMerchantTransactions++;
        }
    }
    return $numOfMerchantTransactions;
}
public function sortTransactionsByDate(): array 
{
    $transactions  = $this->repository->getAllTransactions();
    usort($transactions, function ($transactA, $transactB) {
        $transactADate = new DateTime($transactA->getDate());
        $transactBDate = new DateTime($transactB->getDate());
        if ($transactADate > $transactBDate) {
            return 1;
        } else if ($transactADate < $transactBDate) {
            return -1;
        }
        return 0;
    });
    return $transactions;
}

public function sortTransactionsByAmountDesc(): array
{
    $transactions  = $this->repository->getAllTransactions();
    usort($transactions, function ($transactA, $transactB) {
        $transactAAmount = $transactA->getAmount();
        $transactBAmount = $transactB->getAmount();
        if ($transactAAmount > $transactBAmount) {
            return -1;
        } else if ($transactAAmount < $transactBAmount) {
            return 1;
        }
        return 0;
    });
    return $transactions;
}
```

## Задание 4 Класс TransactionTableRenderer

Класс TransactionTableRenderer, который отвечает только за вывод транзакций в HTML.

реализовывает следующий метод: 

- `render(array $transactions): string` — принимает массив транзакций и возвращает строку с HTML-кодом таблицы.

Метод возвращает HTML-таблицу со следующими столбцами:

- ID транзакции;
- дата;
- сумма;
- описание;
- название получателя;
- категория получателя;
- количество дней с момента транзакции.


```php
public function render(array $transactions): string
    {
        ob_start(); ?>
        <table border="1">
            <tr>
                <td>id</td>
                <td>дата</td>
                <td>сумма</td>
                <td>описание</td>
                <td>название получателя</td>
                <td>категория получателя</td>
                <td>количество дней с момента транзакции</td>
            </tr>

            <?php

            foreach ($transactions as $transaction) { ?>
                <tr>
                    <td><?php echo $transaction->getId() ?></td>
                    <td><?php echo $transaction->getDate() ?></td>
                    <td><?php echo $transaction->getAmount() ?></td>
                    <td><?php echo $transaction->getDescription() ?></td>
                    <td><?php echo $transaction->getMerchant() ?></td>
                    <td><?php echo $transaction->getMerchant() ?></td>
                    <td><?php echo $transaction->getDaysSinceTransaction() ?></td>
                </tr>
            <?php
            } ?>

        </table>
        <?php
        return ob_get_clean();
    }
```

## Задание 5 Создание массива транзакций 

```php
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
```

## Задание 6 Интерфейс TransactionStorageInterface

Создаем интерфейс TransactionStorageInterface.TransactionRepository зеализовывает интерфейс.

```php
interface TransactionStorageInterface
{
    public function addTransaction(Transaction $transaction): void;
    public function removeTransactionById(int $id): void;
    public function getAllTransactions(): array;
    public function findById(int $id): ?Transaction;
}
```

## Библиография
- [moodle](https://elearning.usm.md/course/view.php?id=7161)
- [Создаем динамические веб-сайты с помощью PHP, MySQL, JavaScript, CSS](chrome-extension://efaidnbmnnnibpcajpcglclefindmkaj/https://booster.by/files/oeu.pdf)