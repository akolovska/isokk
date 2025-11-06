<?php

interface Bonus {
    public function addBonus($amount): int;
}
enum AccountType: string
{
    case SAVINGS = 'savings';
    case DEFAULT = 'default';
}

class BankAccount implements Bonus
{
    public $accountNumber;
    public $balance;
    public AccountType $accountType;

    /**
     * @param $accountNumber
     * @param $balance
     */
    public function __construct($accountNumber, $balance, $accountType)
    {
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
        $this->accountType = $accountType;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param mixed $accountNumber
     */
    public function setAccountNumber($accountNumber): void
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance): void
    {
        $this->balance = $balance;
    }

    public function sum(): int
    {
        return $this->balance * 3;
    }

    public function addBonus($amount): int
    {
        return $this->balance += $amount;
    }
}

class SavingAccount extends BankAccount
{
    private $interestRate;

    /**
     * @param $interestRate
     */
    public function __construct($accountNumber, $balance, $accountType, $interestRate)
    {
        parent::__construct($accountNumber, $balance, $accountType);
        $this->interestRate = $interestRate;
    }

    /**
     * @return mixed
     */
    public function getInterestRate()
    {
        return $this->interestRate;
    }

    /**
     * @param mixed $interestRate
     */
    public function setInterestRate($interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    public function applyInterestRate(): int
    {
        $this->balance += $this->interestRate * $this->balance;
        return $this->balance;
    }
}

$bankAccount = new SavingAccount(123, 50000, AccountType::DEFAULT, 3);
$bankAccount->addBonus(5000);
echo $bankAccount->applyInterestRate() . "\n";
echo $bankAccount->accountType->name;