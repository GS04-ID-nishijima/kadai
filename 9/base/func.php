<?php

include dirname(__FILE__).'/msg.php';
include dirname(__FILE__).'/base.php';

function htmlEnc($value) {
    return htmlspecialchars($value,ENT_QUOTES);
}

$repeatEvl1 = array('1', '利用は少ないかな。');
$repeatEvl2 = array('2', 'プチ贅沢の時に！');
$repeatEvl3 = array('3', '日常的に！');

$priceEvl1 = array('1', 'お高め。');
$priceEvl2 = array('2', 'お手頃！');
$priceEvl3 = array('3', 'お買い得！');

function getPlaceText($value) {
    global $place01, $place02, $place03, $place04;

    switch(trim($value)) {
        case $place01[0]:
            return $place01[1];
        case $place02[0]:
            return $place02[1];
        case  $place03[0]:
            return $place03[1];
        case $place04[0]:
            return $place04[1];
    }
}

function getRepeatEvlText($value) {
    global $repeatEvl1, $repeatEvl2, $repeatEvl3;
    switch(trim($value)) {
        case $repeatEvl1[0]:
            return $repeatEvl1[1];
        case $repeatEvl2[0]:
            return $repeatEvl2[1];
        case $repeatEvl3[0]:
            return $repeatEvl3[1];
    }
}

function getPriceEvlText($value) {
    global $priceEvl1, $priceEvl2, $priceEvl3;
    switch(trim($value)) {
        case $priceEvl1[0]:
            return $priceEvl1[1];
        case $priceEvl2[0]:
            return $priceEvl2[1];
        case $priceEvl3[0]:
            return $priceEvl3[1];
    }
}

//DB接続
function dbConnect() {
    global $datasource, $dbUser,$dbPass, $msg006;
    try {
        return new PDO($datasource, $dbUser,$dbPass);
    } catch (PDOException $e) {
        exit($msg006.$e->getMessage());
    }
}

//セッションチェック
function sessionCheck(){
    session_start();
    if( !isset($_SESSION["chk_ssid"]) || ($_SESSION["chk_ssid"] != session_id()) ){
        echo "LOGIN ERROR";
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}
?>