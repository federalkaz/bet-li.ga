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
    echo $lines['home_team'] . ' - ' . $lines['guest_team'].PHP_EOL;
    echo 'Средний прогноз: '. $game['average_forecast'].PHP_EOL;
    echo 'Ставок: '. $game['bets'].PHP_EOL;
    $team1 = $tournamentStatistics->getOptionalManyParameterByTeamName($lines['home_team'],['rating' => true]);
    $team2 = $tournamentStatistics->getOptionalManyParameterByTeamName($lines['guest_team'],['rating' => true]);

    echo var_dump($gameForecast->getGameForecastManualCalculation($team1, $team2)).PHP_EOL;
}

//echo var_dump($gameForecast);