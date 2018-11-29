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
        $table = $dom->find('table tbody', 26);
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            // хозяева
            $element['home_team'] = $item->find('td', 1)->plaintext;
            // гости
            $element['guest_team'] = $item->find('td', 2)->plaintext;
            // прогноз
            $links = $item->find('a');
            foreach ($links as $link) {
                $element['forecast_link'] = 'http://nhl.ru/' . $link->href;
            }

            //$test = $this->getForecastStatistics($element['forecast_link']);
            //////////////////////////////////////////////////////////
            // Инициализируем подключение к сайту
            $html2 = curl_get($element['forecast_link']);
            // Получаем данные в виде DOM-дерева
            $dom2 = str_get_html($html2);
            // Ищем по DOM-дереву необходимую таблицу
            $table2 = $dom2->find('table tbody', 25);
            $i = null;
            // Считываем данные из таблицы построчно
            foreach ($table2->find('tr') as $item2) {
                //echo var_dump($item);
                $i++;
                if ($i == 9) {
                    $element['forecast_coefficient'] = $item2->find('td', 7)->plaintext . PHP_EOL;
                } elseif ($i == 10) {
                    $element['home_team_betting'] = substr($item2->find('td', 2)->plaintext, 6) . PHP_EOL;
                    $element['guest_team_betting'] = substr($item2->find('td', 5)->plaintext, 6) . PHP_EOL;
                }
            }
            //////////////////////////////////////////////////////////
            // Формируем набор данных полученными значениями
            $elements[] = $element;
        }
        //Избавляемся от лишнего уровня вложенности массивов и передаём полученные данные
        $this->dataSet = array_slice($elements, 3);
    }


        public function getForecastStatistics(string $link)
        {
            //////////////////////////////////////////////////////////
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
            }
            //////////////////////////////////////////////////////////
        }


        //echo var_dump($this->dataSet);
}

$nhl = new MatchList('http://nhl.ru/index.php?action=shedul&op=bydate&y=2018&m=11&d=28');