<?php
    namespace site\data;
?>
<!doctype html>
<html lang="ru">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link rel="stylesheet" href="/template/default/css/style.css">
        <link rel="icon" type="image/png" href="favicon.ico">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

        <title>Bet-Liga - Ставки</title>
    </head>
    <body>
        <!-- Навбар -->
        <div class="row">
            <div class="col-xl-12">
                <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #F5DEB3;">
                    <div class="container">
                        <a class="navbar-brand" href="#">
                            <img src="/template/default/img/logo02.png" width="30" height="30" class="d-inline-block align-top" alt="">
                            Jewish / Еврей
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item active">
                                    <a class="nav-link" href="nhl.php">NHL <span class="sr-only">(current)</span></a>
                                </li>
                                <!--
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Футбол
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="#"></a>
                                        <a class="dropdown-item" href="#">100% +</a>
                                        <a class="dropdown-item" href="#">50% +</a>
                                        <a class="dropdown-item" href="#">30% +</a>
                                        <a class="dropdown-item" href="#">20% +</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Хоккей
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="#"></a>
                                        <a class="dropdown-item" href="#">100% +</a>
                                        <a class="dropdown-item" href="#">50% +</a>
                                        <a class="dropdown-item" href="#">30% +</a>
                                        <a class="dropdown-item" href="#">20% +</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Стратегии
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="#"></a>
                                        <a class="dropdown-item" href="#">P1 - P2</a>
                                        <a class="dropdown-item" href="#">P1 - X / X - P2</a>
                                        <a class="dropdown-item" href="#">Один максимальный</a>
                                        <a class="dropdown-item" href="#">Один минимальный</a>
                                    </div>
                                </li>
                                -->
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <a href="#"><i class="fas fa-users"></i>&nbsp;Регистрация</a>
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-left: 1rem;"><i class="fas fa-sign-in-alt"></i>&nbsp;Войти</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Навбар -->
        <div class="container">
            <div class="row slider">
                <div class="col-sm-12">

                    <!-- Джумбатрон -->
                    <div class="jumbotron jumbotron">
                        <div class="container">
                            <img src="/template/default/img/logo01.png" class="rounded float-left" height="250" width="250" alt="Jewish / Еврей - Деньги наше всё!">
                            <h1 class="display-4">Деньги наше всё!</h1>
                            <p class="lead">&laquo;Упал рубль, поднял два&raquo; - приумножаем капитал!</p>
                        </div>
                    </div>
                    <!-- Джумбатрон -->
                </div>
            </div>
            <div class="row content">
                <div class="col-sm-6">
                    <h3 class="header">NHL</h3>
                    <?php

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

                    ?>
                </div>
            </div>

            <div class="row footer">

            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>
</html>