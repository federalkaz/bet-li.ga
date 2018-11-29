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

class MatchList
{
    // Набор данных
    private $dataSet = [];
    private $html2 = null;

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
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            //echo var_dump($item);
            $i++;
            if ($i == 9) {
                echo $item->find('td', 7)->plaintext . PHP_EOL;
            } elseif ($i == 10) {
                echo substr($item->find('td', 2)->plaintext, 6) . PHP_EOL;
                echo substr($item->find('td', 5)->plaintext, 6) . PHP_EOL;
            }

            /*
            // средний прогноз
            $element['average_forecast'] = $item->find('td', 4)->plaintext;
            // ставки
            $element['bets'] = $item->find('td', 5)->plaintext . ' : ' . $item->find('td', 6)->plaintext;
            // Формируем набор данных полученными значениями
            $elements[] = $element;
            */

        }
        /*
        //Избавляемся от лишнего уровня вложенности массивов и передаём полученные данные
        $this->dataSet = array_slice($elements, 3);

        echo var_dump($this->dataSet);
        */
    }


    //echo var_dump($this->dataSet);
}

$nhl = new MatchList('http://nhl.ru/index.php?action=game13&op=prognoz_game&id=27892');