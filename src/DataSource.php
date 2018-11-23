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
    //Матчей
    public $matches;
    //Выигрыши
    public $winnings;
    //Поражения
    public $defeats;
    //Поражения в овертайме / по буллитам
    public $defeatsOvertime;
    //Очки
    public $points;
    //Кол-во побед в основное время и ОТ
    public $totalWins;
    //Забито шайб
    public $cloggedPucks;
    //Пропущено Шайб
    public $missingPucks;
    //Разница шайб
    public $puckDifference;
    //Статистика дома
    public $houseStatistics;
    //Статистика в гостях
    public $statisticsVisit;
    //Статистика в матчах закончившихся буллитами
    public $matchesShootout;
    //Статистика последних 10 матчей
    public $last10Matches;
    //Текущая серия
    public $currentSeries;

    //Набор данных
    public $dataSource = [];

    // Получаем данные с сайта
    public function setData(string $link)
    {
        $data = [];
        // Инициализируем подключение к сайту
        $html = curl_get($link);
        // Получаем данные в виде DOM-дерева
        $dom = file_get_html($html);
        // Ищем по DOM-дереву необходимую таблицу
        $table = $dom->find('table',0)->plaintext;
        // Считываем данные из таблицы построчно




        return $table;//$this->KosherFood = $data;
    }







//Метод принимающий наименование команды и выполняющий действия над ними class('Washington')->matches();
}

$ds = new StatisticCalculation();
echo var_dump($ds->setData('https://www.nhl.com/ru/standings/2018/league'));