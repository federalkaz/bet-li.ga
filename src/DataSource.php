<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 23.11.2018
 * Time: 11:43
 */

namespace site\data;

include_once 'lib/curl_query.php';
include_once 'lib/simple_html_dom.php';

class StatisticCalculation
{

    // Набор данных
    public $dataSource = [];

    function __construct(string $link)
    {
        // Инициализируем подключение к сайту
        $html = curl_get($link);
        // Получаем данные в виде DOM-дерева
        $dom = str_get_html($html);
        // Ищем по DOM-дереву необходимую таблицу
        $table = $dom->find('table',24);
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            // место в турнирной таблице
            $element['rating'] = $item->find('td', 0)->plaintext;
            // наименование команды
            $element['name'] = substr($item->find('td', 1)->plaintext, 1);
            // набранные очки
            $element['points'] = $item->find('td', 3)->plaintext;
            // потерянные очки
            $element['lost_points'] = $item->find('td', 4)->plaintext;
            // количество проведенных игр
            $element['games'] = $item->find('td', 5)->plaintext;
            // выиграно игр
            $element['winnings'] = $item->find('td', 6)->plaintext;
            // поражения
            $element['defeats'] = $item->find('td', 7)->plaintext;
            // поражение в овертайме
            $element['defeats_overtime'] = $item->find('td', 8)->plaintext;
            // выигрыш по булитам
            $element['winnings_overtime'] = $item->find('td', 9)->plaintext;
            // забитые шайбы
            $element['clogged_pucks'] = $item->find('td', 10)->plaintext;
            // пропущенные шайбы
            $element['missing_pucks'] = $item->find('td', 11)->plaintext;
            // разница забитых и пропущенных шайб
            $element['puck_difference'] = $item->find('td', 12)->plaintext;
            // процент набранных очков;
            $element['percentage_points'] = $item->find('td', 13)->plaintext;
            // Формируем набор данных полученными значениями
            $this->dataSource[] = $element;
        }
    }

    // Получаем данные с сайта
    public function getAllData()
    {
        return $this->dataSource;
    }

    // Получаем данные о команде по месту в турнирной таблице
    public function getRatingData($rating)
    {
        foreach ($this->dataSource as $item) {
            if ($item['rating'] == $rating) {
                return $item;
            }
        }
        return 'Данная команда не найдена! Убедитесь в правильности её написания либо существовании.';
    }

    // Получаем данные о команде по её имени
    public function getNameData(string $name)
    {
        // Начинаем перебирать строки таблицы (команды со статистикой)
        foreach ($this->dataSource as $item) {
            // Запоминаем номер просматриваемой команды в турнирной таблице
            $key = $item['rating'];
            // И в случае её нахождения возвращаем набор данных
            if ($item['name'] === $name) {
                return $this->getRatingData($key);//тут вызвать функцию возврата данных по турнирному положению команды
            // В случае неудачи сообщаем об этом
            }
        }
        return 'Данная команда не найдена! Убедитесь в правильности её написания либо существовании.';
    }

    // Получаем нужные данные по имени команды
    public function getOptionalOneParameter(string $name, $parameter)
    {
        // Формируем набор данных для запрашиваемой команды
        $data = $this->getNameData($name);
        // Возвращаем запрашиваемый параметр
        switch ($parameter) {
            case 'rating':
                return $data['rating'];
            case 'points':
                return $data['points'];
            case 'lost_points':
                return $data['lost_points'];
            case 'games':
                return $data['games'];
            case 'winnings':
                return $data['winnings'];
            case 'defeats':
                return $data['defeats'];
            case 'defeats_overtime':
                return $data['defeats_overtime'];
            case 'winnings_overtime':
                return $data['winnings_overtime'];
            case 'clogged_pucks':
                return $data['clogged_pucks'];
            case 'missing_pucks':
                return $data['missing_pucks'];
            case 'puck_difference':
                return $data['puck_difference'];
            case 'percentage_points':
                return $data['percentage_points'];
            default:
                return 'Неверный параметр! Ещё раз проверьте написание атрибута который хотите получить.';
        }
    }

    // Получаем нужные данные по имени команды заранее указав необходимые параметры
    public function getOptionalManyParameter(string $name, array $parameters = [
        'rating' => false,
        'name' => false,
        'points' => false,
        'lost_points' => false,
        'games' => false,
        'winnings' => false,
        'defeats' => false,
        'defeats_overtime' => false,
        'winnings_overtime' => false,
        'clogged_pucks' => false,
        'missing_pucks' => false,
        'puck_difference' => false,
        'percentage_points' => false
    ])
    {
        // Получаем набор данных для запрашиваемой команды
        $data = $this->getNameData($name);
        // Начинаем пробегать по массиву с запрашиваемыми параметрам
        foreach ($parameters as $parameter => $value) {
            echo var_dump($parameter).PHP_EOL;
        }
        foreach ($parameters as $parameter => $value) {
            if ($parameter != 'rating') {
                unset($data['rating']);
            }
            if ($parameter != 'name') {
                unset($data['name']);
            }
            if ($parameter != 'points') {
                unset($data['points']);
            }
            if ($parameter != 'lost_points') {
                unset($data['lost_points']);
            }
            if ($parameter != 'games') {
                unset($data['games']);
            }
            if ($parameter != 'winnings') {
                unset($data['winnings']);
            }
            if ($parameter != 'defeats') {
                unset($data['defeats']);
            }
            if ($parameter != 'defeats_overtime') {
                unset($data['defeats_overtime']);
            }
            if ($parameter != 'winnings_overtime') {
                unset($data['winnings_overtime']);
            }
            if ($parameter != 'clogged_pucks') {
                unset($data['clogged_pucks']);
            }
            if ($parameter != 'missing_pucks') {
                unset($data['missing_pucks']);
            }
            if ($parameter != 'puck_difference') {
                unset($data['puck_difference']);
            }
            if ($parameter != 'percentage_points') {
                unset($data['percentage_points']);
            }
        }
        if ($data == null) {
            return 'Не выбран ни один возвращаемый параметр! Пожалуйста, выберите хотя бы один.';
        } else {
            // Возвращаем запрашиваемые данные
            return $data;
        }
    }


//Метод принимающий наименование команды и выполняющий действия над ними class('Washington')->matches();
}

$nhl = new StatisticCalculation('http://nhl.ru/index.php?action=shedul&op=standings_total');
//$data = $nhl->getAllData();
//echo var_dump($nhl->getAllData());
/*
foreach ($data as $item) {
    echo $item['rating'].' | '.$item['name'].' | '.$item['points'].' | '.$item['lost_points'].' | '.$item['games'].' | '.$item['winnings'].' | '.$item['defeats'].' | '.$item['defeats_overtime'].' | '.$item['winnings_overtime'].' | '.$item['clogged_pucks'].' | '.$item['missing_pucks'].' | '.$item['puck_difference'].' | '.$item['percentage_points'].PHP_EOL;
}
*/

//echo var_dump($nhl->getNameData('Калгари')->getRating());
//echo var_dump($nhl->getRatingData(11));
//echo $nhl->getOptionalOneParameter('Калгари', 'games');
$parameters = [
    'rating' => true,
    'points' => true,
    'games' => true
];
echo var_dump($nhl->getOptionalManyParameter('Нэшвилл', $parameters));