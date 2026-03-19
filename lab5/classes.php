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

    public function getDaysSinceTransaction(): int
    {
        $tz = ini_get('date.timezone');
        $dtz = new DateTimeZone($tz);
        $currentDate = new DateTime('now', $dtz);
        $transactionDate = new DateTime($this->date, $dtz);
        return $transactionDate->diff($currentDate)->days;
    }
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
}

class TransactionRepository implements TransactionStorageInterface
{
    private array $transactions = [];
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
}

class TransactionManager
{
    public function __construct(private TransactionStorageInterface  $repository) {}

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
