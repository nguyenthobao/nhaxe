<?php
function formatNumber($value, $currency_code = null) {
    global $web;
    $currency_code = $web['currentcy'];
    $r             = number_format($value, 2, ',', '.');
    $r_arrays      = explode(',', $r);
    $price         = 0;
    if (intval($r_arrays[1]) == 0) {
        $price = $r_arrays[0];
    } else {
        $price = implode(',', $r_arrays);
    }
   
    if ($currency_code == '$') {
        return '$ '.number_format($value, 2, '.', ',');
    } else {
        $price .= ' ' . $currency_code;
    }
    
    return $price;
}
function trimCurrentcy($value) {
    global $web;
    $currency_code = $web['currentcy'];
    return trim(str_replace(',', '.', str_replace('.', '', str_replace($currency_code, '', $value))));

}
function cutString($string, $start = 0, $limit, $append = ' &hellip;') {
    global $web;
    mb_internal_encoding("UTF-8");
    if (strlen($string) > $limit) {
        $words = mb_substr(strip_tags(html_entity_decode($string, ENT_QUOTES, 'UTF-8')), $start, $limit, 'utf-8');
        if ($web['lang_use'] == 'jp' || $web['lang_use'] == 'cn') {
            return $words;
        }
        $limit = $limit + 1;
        $words = explode(' ', $words, $limit);
        array_pop($words);
        $words = implode(' ', $words) . $append;
        return $words;
    } else {
        return $string;
    }
}
?>