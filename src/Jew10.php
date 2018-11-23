<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 16.02.2018
 * Time: 20:15
 */

class Jew10
{
    public $coefficient1;
    public $coefficient2;
    public $coefficient3; // Коэффициенты на исход
    public $bet1;
    public $bet2; // Размеры ставок
    public $balance; // Сумма ставок
    public $result1;
    public $result2; // Прибыль
    public $profit1;
    public $profit2; // Чистая прибыль
    public $percent1;
    public $percent2; // Процентные доли
    public $dohodnost; // Средняя доходность

    public function setBet1($bet1): void
    {
        $this->bet1 = $bet1;
    }
    public function getBet1()
    {
        // Если первый коэффициент больше второго
        if ($this->coefficient1 >= $this->coefficient2) {
            // то возвращаем наименьшую ставку
            return ($this->bet1 >= $this->bet2) ? $this->bet2 : $this->bet1;
        } else {
            // в противном случае наибольшую
            return ($this->bet1 >= $this->bet2) ? $this->bet1 : $this->bet2;
        }
    }
    public function setBet2($bet2): void
    {
        $this->bet2 = $bet2;
    }
    public function getBet2()
    {
        // Если первая ставка не является второй, то возвращаем первую, иначе вторую
        return ($this->getBet1() == $this->bet2) ? $this->bet1 : $this->bet2;
    }
    public function setResult1($result1): void
    {
        $this->result1 = $result1;
    }
    public function getResult1()
    {
        return $this->result1;
    }
    public function setResult2($result2): void
    {
        $this->result2 = $result2;
    }
    public function getResult2()
    {
        return $this->result2;
    }
    public function setProfit1($profit1): void
    {
        $this->profit1 = $profit1;
    }
    public function getProfit1()
    {
        return $this->profit1;
    }
    public function setProfit2($profit2): void
    {
        $this->profit2 = $profit2;
    }
    public function getProfit2()
    {
        return $this->profit2;
    }
    public function setPercent1($percent1): void
    {
        $this->percent1 = $percent1;
    }
    public function getPercent1()
    {
        return $this->percent1;
    }
    public function setPercent2($percent2): void
    {
        $this->percent2 = $percent2;
    }
    public function getPercent2()
    {
        return $this->percent2;
    }

    public function profit($coefficient1, $coefficient2, $balance)
    {
        $this->coefficient1 = $coefficient1;
        $this->coefficient2 = $coefficient2;
        // Определим процентные соотношения коэффициентов
        $this->setPercent1(round($this->coefficient1 * 100 / ($this->coefficient1 + $this->coefficient2)));
        $this->setPercent2(round($this->coefficient2 * 100 / ($this->coefficient1 + $this->coefficient2)));
        // Определим размеры совершаемых ставок по каждому из коэффициентов
        $this->setBet1(round($balance * $this->getPercent1() / 100));
        $this->setBet2(round($balance * $this->getPercent2() / 100));
        // Считаем общую прибыль по каждому исходу
        $this->setResult1(round($this->getBet1() * $this->coefficient1));
        $this->setResult2(round($this->getBet2() * $this->coefficient2));
        // Реализовать рассчёт чистой прибыли и вывести процент доходности
        $this->setProfit1($this->getResult1() - $this->getBet1() - $this->getBet2());
        $this->setProfit2($this->getResult2() - $this->getBet2() - $this->getBet1());
        // Высчитаем среднюю доходность события
        $this->dohodnost = round(($this->getProfit1() + $this->getProfit2()) * 100 / $balance / 2);
        return 0;
    }

}

$Jew = new Jew10();
$Jew->profit(1.45, 2.75, 1000);
echo 'Коэф1 --> '.$Jew->coefficient1.PHP_EOL;
echo 'Коэф2 --> '.$Jew->coefficient2.PHP_EOL;


echo 'Процентная доля 1: '.$Jew->getPercent1().PHP_EOL;
echo 'Процентная доля 2: '.$Jew->getPercent2().PHP_EOL;


echo 'Ставка на П1: '.$Jew->getBet1().PHP_EOL;
echo 'Ставка на П2: '.$Jew->getBet2().PHP_EOL;
echo 'Общая прибыль по П1: '.$Jew->getResult1().PHP_EOL;
echo 'Общая прибыль по П2: '.$Jew->getResult2().PHP_EOL;
echo 'Чистая прибыль по П1: '.$Jew->getProfit1().PHP_EOL;
echo 'Чистая прибыль по П2: '.$Jew->getProfit2().PHP_EOL;
echo 'Средняя доходность --> '.$Jew->dohodnost.'%'.PHP_EOL;

// написать вторую версию - с 6 ставками на 3 события