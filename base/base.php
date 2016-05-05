<?php
$baseDirPath = "./data";
$baseUploadDirPath = "$baseDirPath/img";
$baseDataDirPath = "$baseDirPath/cmt";

$cntFilePath = "$baseDirPath/cnt.txt";

function htmlEnc($value) {
    return htmlspecialchars($value,ENT_QUOTES);
}

$place01 = array('01', '5月7日(土)＠表参道');
$place02 = array('02', '5月8日(日)＠六本木');
$place03 = array('03', '5月14日(土)＠恵比寿');
$place04 = array('04', '5月21日日(土)＠有楽町');

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