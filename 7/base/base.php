<?php
$baseDirPath = "./data";
$baseUploadDirPath = "$baseDirPath/img";
$baseDataDirPath = "$baseDirPath/cmt";

$cntFilePath = "$baseDirPath/cnt.txt";

function htmlEnc($value) {
    return htmlspecialchars($value,ENT_QUOTES);
}

$datasource = 'mysql:dbname=gs_db;charset=utf8;host=localhost';
$dbUser = 'root';
$dbPass = '';

$getNickNameSQL = "SELECT nickname FROM user WHERE id =:id";
$getShopInfoSQL = "SELECT id, shop_name FROM shop";
$getShopNameSQL = "SELECT shop_name FROM shop WHERE id = :id";
$getHoldInfoByShopIdSQL = 
    "SELECT
        hi.id as id
        , hi.hold_ymd as hold_ymd
        , p.place_name as place_nmae 
    FROM hold_info as hi 
    INNER JOIN place as p ON hi.place_id = p.id 
    WHERE hi.shop_id = :shopId";
$getHoldInfoByHoldInfoIdSQL = 
    "SELECT
        DATE_FORMAT(hi.hold_ymd, '%Y/%c/%e') as hold_ymd
        , hi.place_id as place_id
        , p.place_name as place_name
    FROM hold_info as hi 
    INNER JOIN place as p ON hi.place_id = p.id 
    WHERE hi.id = :id";
$insShopReportSQL = 
    "INSERT INTO report 
    (id, shop_id, report_user_id, report_ymdhm, hold_ymd, place_id, repeat_evl, price_evl, buy_pdt, price, impression)
    VALUES(NULL, :shopId, :reportUserId, sysdate(), :holdYmd, :placeId, :repeatEvl, :priceEvl, :buyPdt, :price, :impression)";
$getReportByShopIddSQL = 
    "SELECT
        r.id
        ,u.nickname
        , DATE_FORMAT(r.report_ymdhm, '%Y年%c月%e日 %H時%i分') as report_ymdhm
        , DATE_FORMAT(r.hold_ymd, '%Y/%c/%e') as hold_ymd
        , p.place_name as place_name, r.repeat_evl, r.price_evl, r.buy_pdt, r.price, r.impression
    FROM report as r
    INNER JOIN user as u ON r.report_user_id = u.id 
    INNER JOIN place as p ON r.place_id = p.id 
    WHERE r.shop_id = :shopId
    ORDER BY r.id DESC";

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

?>