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
        $elements = [];
        // Инициализируем подключение к сайту
        $html = curl_get($link);
        // Получаем данные в виде DOM-дерева
        $dom = str_get_html($html);
        // Ищем по DOM-дереву необходимую таблицу
        $table = $dom->find('table tbody', 26);
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            // хозяева
            $element['home_team'] = $item->find('td', 1)->plaintext.PHP_EOL;
            // гости
            $element['guest_team'] = $item->find('td', 2)->plaintext.PHP_EOL;
            //Вставляем проверку, если вместо наименования команды получаем что-то иное, то матчей на текущую дату нет
            if ($element['guest_team'][0] == '0') {
                unset($element);
                exit;
            }
            // прогноз
            $links = $item->find('a');
            foreach($links as $link) {
                $element['forecast_link'] = 'http://nhl.ru/'.$link->href;
            }
            // Формируем набор данных полученными значениями
            $elements[] = $element;
        }
        //Избавляемся от лишнего уровня вложенности массивов и передаём полученные данные
        $this->dataSet = array_slice($elements, 3);
    }

    // Возвращаем список матчей
    function getAllMatch()
    {
        return $this->dataSet;
    }
}

//$nhl = new MatchList('http://nhl.ru/index.php?action=shedul&op=bydate&y=2018&m=12&d=26');
//echo var_dump($nhl->getAllMatch());