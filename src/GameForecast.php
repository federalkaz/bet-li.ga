<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 27.11.2018
 * Time: 20:41
 */

namespace site\data;

include_once 'lib/curl_query.php';
include_once 'lib/simple_html_dom.php';

class GameForecast
{
    // Набор данных
    private $dataSet = [];

    // Формируем набор данных
    function __construct(string $link)
    {
        // Инициализируем подключение к сайту
        $html = curl_get($link);
        // Получаем данные в виде DOM-дерева
        $dom = str_get_html($html);
        // Ищем по DOM-дереву необходимую таблицу
        $table = $dom->find('table tbody', 25);
        $i = null;
        $element = [];
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            //echo var_dump($item);
            $i++;
            if ($i == 9) {
                // средний прогноз
                $element['average_forecast'] = $item->find('td', 7)->plaintext;
                //echo 'Соотношение ставок: '.$item->find('td', 7)->plaintext . PHP_EOL;
            } elseif ($i == 10) {
                // ставки
                $element['bets'] = $item->find('td', 2)->plaintext . ' : ' . $item->find('td', 5)->plaintext;
                //echo 'Ставок на хозяев: '.substr($item->find('td', 2)->plaintext, 6) . PHP_EOL;
                //echo 'Ставок на гостей: '.substr($item->find('td', 5)->plaintext, 6) . PHP_EOL;
            }
            // Формируем набор данных полученными значениями
            $this->dataSet = $element;
        }
    }

    // Предоставляем прогноз встречи с сайта
    function getGameForecastSite()
    {
        return $this->dataSet;
    }

    function getGameForecastManualCalculation(array $teamOne, array $teamTwo)
    {
        // LevelSkills
        // Определяем степени на которые разбиваются команды согласно ТЗ
        $degreeOne = $teamOne['rating'];
        if ($degreeOne <= 5) {
            $this->dataSet['degreeOne'] = 1;
        } elseif ((5 < $degreeOne) && ($degreeOne <= 10)) {
            $this->dataSet['degreeOne'] = 2;
        } elseif ((10 < $degreeOne) && ($degreeOne <= 15)) {
            $this->dataSet['degreeOne'] = 3;
        } elseif ((15 < $degreeOne) && ($degreeOne <= 20)) {
            $this->dataSet['degreeOne'] = 4;
        } elseif ((20 < $degreeOne) && ($degreeOne <= 25)) {
            $this->dataSet['degreeOne'] = 5;
        } else {
            $this->dataSet['degreeOne'] = 6;
        }

        $degreeTwo = $teamTwo['rating'];
        if ($degreeTwo <= 5) {
            $this->dataSet['degreeTwo'] = 1;
        } elseif ((5 < $degreeTwo) && ($degreeTwo <= 10)) {
            $this->dataSet['degreeTwo'] = 2;
        } elseif ((10 < $degreeTwo) && ($degreeTwo <= 15)) {
            $this->dataSet['degreeTwo'] = 3;
        } elseif ((15 < $degreeTwo) && ($degreeTwo <= 20)) {
            $this->dataSet['degreeTwo'] = 4;
        } elseif ((20 < $degreeTwo) && ($degreeTwo <= 25)) {
            $this->dataSet['degreeTwo'] = 5;
        } else {
            $this->dataSet['degreeTwo'] = 6;
        }

        // Определяем разницу положения в турнирной таблице
        $levelSkills = abs($this->dataSet['degreeOne'] - $this->dataSet['degreeTwo']);

        switch ($levelSkills) {
            case 0:
                $this->dataSet['positionDifference'] = 'Самая низкая разница положения в турнирной таблице!';
                return $this->dataSet;
            case 1:
                $this->dataSet['positionDifference'] = 'Низкая разница положения в турнирной таблице!';
                return $this->dataSet;
            case 2:
                $this->dataSet['positionDifference'] = 'Разница положения в турнирной таблице ниже среднего!';
                return $this->dataSet;
            case 3:
                $this->dataSet['positionDifference'] = 'Средняя разница положения в турнирной таблице!';
                return $this->dataSet;
            case 4:
                $this->dataSet['positionDifference'] = 'Высокая разница положения в турнирной таблице!';
                return $this->dataSet;
            case 5:
                $this->dataSet['positionDifference'] = 'Самая высокая разница положения в турнирной таблице!';
                return $this->dataSet;
            default:
                echo "Произошла ошибка! Полученный LevelSkills неверный!";
        }
    }
}


/*
$nhl = new GameForecast('http://nhl.ru/index.php?action=game13&op=prognoz_game&id=28010');
echo var_dump($nhl->getGameForecastSite());
*/