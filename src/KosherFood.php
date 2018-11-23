<?php

include_once 'lib/curl_query.php';
include_once 'lib/simple_html_dom.php';
include_once 'Jew10.php';

class KosherFood extends Jew10
{
    public $link; // Ссылка на страницу со списком событий
    public $titleEvent; // Наименование события
    public $dateTimeEvent; // Дата и время события
    public $p1;
    public $x;
    public $p2; // Возможные исходы события
    public $KosherFood = []; // Набор данных

    // Получаем данные с сайта
    public function setKosherFood($link)
    {
        // Инициализируем подключение к сайту
        $html = curl_get($link);
        // Получаем данные в виде DOM-дерева
        $dom = str_get_html($html);
        // Ищем по DOM-дереву необходимую таблицу
        $table = $dom->find('table', 5);
        // Заводим счётчик
        $i = 1;
        // Считываем данные из таблицы построчно
        foreach ($table->find('tr') as $item) {
            if (($i % 2) != 0) {
                // ссылка на событие
                $element['link'] = $item->find('font.m a', 0)->href;
                // наименование события
                $element['title'] = $item->find('td', 1)->plaintext;
                // дата и время события
                $element['datetime'] = substr($item->find('td', -2)->plaintext, 8, strlen($item->find('td', -2)->plaintext) - 8);//первая пустая, вторая полная
            } else {
                // коэффициент на победу первой команды
                $element['p1'] = (float)substr($item->find('div>nobr', 0)->plaintext, 18, 5);
                // коэффициент на ничью
                $element['x'] = (float)substr($item->find('div>nobr', 1)->plaintext, 17, 5);
                // коэффициент на победу второй команды
                $element['p2'] = (float)substr($item->find('div>nobr', 2)->plaintext, 18, 5);
            }
            $data[] = $element;
            $i++;
        }
        return $this->KosherFood = $data;
    }

    public function getKosherFood(string $link)
    {
        $i = 1;
        $this->setKosherFood($link);
        /*
        foreach ($this->KosherFood as $item) {
            if (($i % 2) == 0) {
                echo '---------------<br>';
                echo $item['datetime'].' - '.'<a href=https://olimp.kz'.$item['link'].' target=_blank>'.$item['title'].'</a>'.'<br>';
                echo $item['p1'] . ' - ' . $item['x'] . ' - ' . $item['p2'] . '<br>';
            }
            $i++;
        }
        */
        echo '<table class="table table-bordered table-striped table-sm table-dark">'.PHP_EOL;
        echo '                        <tbody>'.PHP_EOL;
        foreach ($this->KosherFood as $item) {
            if (($i % 2) == 0) {
                echo '                            <tr>'.PHP_EOL;
                echo '                                <td scope="col" colspan="3">'.$item['datetime'].' - '.'<a href=https://olimp.kz'.
                    $item['link'].' target=_blank>'.$item['title'].'</a>'.'</td>'.PHP_EOL;
                echo '                                <td scope="col">Доходность</td>'.PHP_EOL;
                echo '                            </tr>'.PHP_EOL;
                echo '                            <tr>'.PHP_EOL;
                echo '                                <td scope="col">П1 - '.$item['p1'].'</td>'.PHP_EOL;
                echo '                                <td scope="col">Х - '.$item['x'].'</td>'.PHP_EOL;
                echo '                                <td scope="col">П2 - '.$item['p2'].'</td>'.PHP_EOL;
                $this->profit($item['p1']+0, $item['p2']+0, 1000);
                echo '                                <td scope="col">' . $this->dohodnost . '%</td>'.PHP_EOL;
                echo '                            </tr>'.PHP_EOL;
                echo '                            <tr>'.PHP_EOL;
                echo '                                <td scope="col1">' . $this->getBet1() . '</td>'.PHP_EOL;
                echo '                                <td scope="col1"></td>'.PHP_EOL;
                echo '                                <td scope="col1">' . $this->getBet2() . '</td>'.PHP_EOL;
                echo '                                <td scope="col1"></td>'.PHP_EOL;
                echo '                            </tr>'.PHP_EOL;
                echo '                            <tr>'.PHP_EOL;
                echo '                                <td scope="col1">' . $this->getProfit1() . '</td>'.PHP_EOL;
                echo '                                <td scope="col1"></td>'.PHP_EOL;
                echo '                                <td scope="col1">' . $this->getProfit2() . '</td>'.PHP_EOL;
                echo '                                <td scope="col1"></td>'.PHP_EOL;
                echo '                            </tr>'.PHP_EOL;
            }
            $i++;
        }
        echo '                        </tbody>'.PHP_EOL;
        echo '                    </table>'.PHP_EOL;
        return ;
    }
}