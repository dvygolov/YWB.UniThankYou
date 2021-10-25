<?php
function insert_after_tag($html, $needle, $str_to_insert)
{
    $lastPos = 0;
    $positions = array();
    while (($lastPos = strpos($html, $needle, $lastPos)) !== false) {
        $positions[] = $lastPos;
        $lastPos = $lastPos + strlen($needle);
    }
    $positions = array_reverse($positions);
    foreach ($positions as $pos) {
        $finalpos=$pos+strlen($needle);
        //если у нас задан НЕ закрытый тег, то надо найти его конец
        if (strpos($needle,'>')===false)
        {
            while($html[$finalpos]!=='>')
                $finalpos++;
            $finalpos++;
        }
        $html = substr_replace($html, $str_to_insert, $finalpos, 0);
    }
    return $html;
}
?>