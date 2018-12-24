<?php

class BetBet
{
    //Баланс кабинета
    private $balance = 0;
    //Ставка
    private $bet = 100;
    //Коэффициент
    private $rate = 1.7;

    public function analizator()
    {
        for ($i = 1; $i <= 10; $i++) {
            echo $i . ') ' . $this->balance = $this->balance + $this->bet * $this->rate . PHP_EOL;

        }
    }
}

$bet = new BetBet();
$bet->analizator();