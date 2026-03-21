<?php

declare(strict_types=1);


class Transaction
{
    public function __construct(
        private int $id,
        private string $date,
        private float $amount,
        private  string $description,
        private string $merchant
    ) {}

    /**
     * Метод, возвращающий количество дней, прошедших с даты транзакции
     * @return int - количество дней с даты транзакции 
     */
    public function getDaysSinceTransaction(): int
    {
        $tz = ini_get('date.timezone');
        $dtz = new DateTimeZone($tz);
        $currentDate = new DateTime('now', $dtz);
        $transactionDate = new DateTime($this->date, $dtz);
        return $transactionDate->diff($currentDate)->days;
    }
    /**
     * Метод, возвращающий id транзакции 
     * @return int 
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * Метод, возвращающий дату транзакции  
     * @return string 
     */
    public function getDate(): string
    {
        return $this->date;
    }
    /**
     * Метод, возвращающий стоимость транзакции  
     * @return float 
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
    /**
     * Метод, возвращающий описание транзакции 
     * @return string 
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * Метод, возвращающий название торговца 
     * @return string  
     */
    public function getMerchant(): string
    {
        return $this->merchant;
    }
}

class TransactionRepository implements TransactionStorageInterface
{
    private array $transactions = [];

    /**
     * Метод, добавляет новую транзакцию
     * @param array $transaction - массив с транзакциями
     * @return void  
     */
    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    
    /**
     * Метод, добавляет новую транзакцию
     * @param array $transaction - массив с транзакциями
     * @return void  
     */
    public function removeTransactionById(int $id): void
    {
        foreach ($this->transactions as $num => $transaction) {
            if ($transaction->getId() === $id) {
                unset($this->transactions[$num]);
            }
        }
    }
    
    /**
     * Метод, возвращает массив всех транзакций 
     * @return array - массив с транзакциями 
     */
    public function getAllTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * Метод, ищет транзакцию по id 
     * @param int $id - id транзакции, которую мы ищем 
     * @return Transaction - объект транзакции, с заданым id 
     */
    public function findById(int $id): ?Transaction
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getId() === $id) {
                return $transaction;
            }
        }
        return null;
    }
}

class TransactionManager
{
    public function __construct(private TransactionStorageInterface  $repository) {}

    /**
     * Метод, считает общую сумму транзакций
     * @return float - сумма всех транзакций  
     */
    public function calculateTotalAmount(): float
    {
        $totalAmount = 0;
        foreach ($this->repository->getAllTransactions() as $transaction) {
            $totalAmount += $transaction->getAmount();
        }
        return $totalAmount;
    }
    /**
     * Метод, считает общую сумму транзакций в определенный период времени 
     * @param string  $startDate - стартовая дата интервала 
     * @param string  $endDate - конечная дата интервала 
     * @return float - сумма всех транзакций  за интервал времени 
     */
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
    /**
     * Метод, считает количество транзакций у определенного торговца  
     * @param string  $merchant - название продавца 
     * @return int - количество транзакций 
     */
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
    /**
     * Метод, сортирует массив по дате 
     * @return array - сортированный массив 
     */
    public function sortTransactionsByDate(): array // сортировка по дате 
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
    /**
     * Метод, сортирует массив по сумме ( в убывании) 
     * @return array - массив с транзакциями 
     */
    public function sortTransactionsByAmountDesc(): array
    // сортировку транзакций по сумме по убыванию
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
}

final class TransactionTableRenderer
{
    /**
     * Метод, генерирует таблицу с транзакциями (html)  
     * @param array $transactions - массив с транзакциями 
     * @return string - строка с таблицей html 
     */
    public function render(array $transactions): string
    {
        ob_start();
?>
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
}

interface TransactionStorageInterface
{
    public function addTransaction(Transaction $transaction): void;
    public function removeTransactionById(int $id): void;
    public function getAllTransactions(): array;
    public function findById(int $id): ?Transaction;
}
