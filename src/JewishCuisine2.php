<?php

include_once 'lib/curl_query.php';
include_once 'lib/simple_html_dom.php';

class JewishCuisine2
{

}
$link1 = 'https://olimp.kz/betting/index.php?page=line&action=2&sel[]=1928636';
$link2 = 'https://olimp.kz/betting/index.php?page=line&action=2&sel[]=17214';
$link3 = 'https://olimp.kz/betting/index.php?page=line&action=2&sel[]=354';
$link4 = 'https://olimp.kz/betting/index.php?page=line&action=2&sel[]=11657';

$html = curl_get($link4);
$dom = str_get_html($html);

$table = $dom->find('table',5);
$i = 1;

foreach ($table->find('tr') as $item){
    if (($i % 2) != 0) {
        $element['link'] = $item->find('font.m a', 0)->href;
        $element['title'] = $item->find('td',1)->plaintext;
        $element['datetime'] = substr($item->find('td', -2)->plaintext,8,strlen($item->find('td', -2)->plaintext) - 8);//первая пустая, вторая полная
    }else{
        $element['p1'] = (float)substr($item->find('div>nobr', 0)->plaintext, 18, 5);
        $element['x'] = (float)substr($item->find('div>nobr', 1)->plaintext, 17, 5);
        $element['p2'] = (float)substr($item->find('div>nobr', 2)->plaintext, 18, 5);
    }
    $data[] = $element;
    $i++;
}

//echo '<pre>'.print_r($data).'</pre>';
$i = 1;

foreach ($data as $item1) {
    if (($i % 2) == 0) {
        echo '---------------<br>';
        echo $item1['datetime'].' - '.'<a href=https://olimp.kz'.$item1['link'].' target=_blank>'.$item1['title'].'</a>'.'<br>';
        echo $item1['p1'] . ' - ' . $item1['x'] . ' - ' . $item1['p2'] . '<br>';
    }
    $i++;
}

