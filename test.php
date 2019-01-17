<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 27.11.2018
 * Time: 20:41
 */

namespace site\data;

include_once 'src/MatchList.php';
include_once 'src/TournamentStatistics.php';
include_once 'src/GameForecast.php';

// Сформируем ссылку на игровое событие
$date = [
    'year' => date('Y'),
    'month' => date('m'),
    'day' => date('d')
];
$linkMatchList = "http://nhl.ru/index.php?action=shedul&op=bydate&y=$date[year]&m=$date[month]&d=$date[day]";

// Создаём экземпляры объектов
$matchList = new MatchList($linkMatchList);
$tournamentStatistics = new TournamentStatistics('http://nhl.ru/index.php?action=shedul&op=standings_total');


// Формируем список игр
foreach ($matchList->getAllMatch() as $lines) {
    // Создаём объекты с прогнозами встреч
    $gameForecast = new GameForecast("$lines[forecast_link]");
    $game = $gameForecast->getGameForecastSite();


    // Выводим информацию
    echo $lines['home_team'] . ' - ' . $lines['guest_team'].PHP_EOL.'<br>';
    //echo 'Средний прогноз: '. $game['average_forecast'].PHP_EOL.'<br>';
    //echo 'Ставок: '. $game['bets'].PHP_EOL.'<br>';

    $team1 = $tournamentStatistics->getOptionalManyParameterByTeamName(rtrim($lines['home_team']), ['rating' => true]);
    $team2 = $tournamentStatistics->getOptionalManyParameterByTeamName(rtrim($lines['guest_team']), ['rating' => true]);
    //echo var_dump($team1).'<br>';
    //echo var_dump($team2).'<br>';
    $result = $gameForecast->getGameForecastManualCalculation($team1, $team2);

    echo 'Средний прогноз: '.$result['average_forecast'].'<br>';
    echo 'Ставок: '.$result['bets'].'<br>';
    echo $result['positionDifference'].'<br>';
    echo '<br>';
}

//echo var_dump($gameForecast);