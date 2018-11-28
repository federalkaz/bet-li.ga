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
            $element['home'] = $item->find('td', 1)->plaintext;
            // гости
            $element['guest'] = $item->find('td', 2)->plaintext;
            // прогноз
            $links = $item->find('a');
            foreach($links as $link) {
                $element['forecast'] = 'http://nhl.ru/'.$link->href;
            }
            // Формируем набор данных полученными значениями
            $this->dataSet[] = $element;
        }

        //$this->dataSet[] = $table;
        echo var_dump($this->dataSet);
    }
}

$nhl = new MatchList('http://nhl.ru/index.php?action=shedul&op=bydate&y=2018&m=11&d=27');