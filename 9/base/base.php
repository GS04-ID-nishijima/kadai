<?php
$baseDirPath = "./data";
$baseUploadDirPath = "$baseDirPath/img";
$baseDataDirPath = "$baseDirPath/cmt";

$datasource = 'mysql:dbname=gs_db;charset=utf8;host=localhost';
$dbUser = 'root';
$dbPass = '';

$checkPasswordSQL = "SELECT id, nickname, type FROM user WHERE email=:email and password = :password and del_flg=0";
$getNickNameSQL = "SELECT nickname FROM user WHERE id =:id";
$getUserInfoSQL = "SELECT email, nickname FROM user WHERE id = :id";
$getUserInfoForAdminSQL = 
    "SELECT
    email as email
    , u.nickname as nickname
    , k.id as authority_id
    , k.text as authority
    , s.id as shop_id
    , s.shop_name as shop_name
    FROM user as u
    INNER JOIN kbn as k ON u.type = k.id
    LEFT OUTER JOIN shop as s ON u.shop_id = s.id
    WHERE u.id = :id
    AND k.cd = 3
    ORDER BY u.id";
$getUserListSQL = 
    "SELECT
    u.id as id
    , u.email as email
    , u.nickname as nickname
    , k.text as authority
    , s.shop_name as shop_name
    FROM user as u
    INNER JOIN kbn as k ON u.type = k.id
    LEFT OUTER JOIN shop as s ON u.shop_id = s.id
    WHERE k.cd = 3 AND u.del_flg = 0
    ORDER BY u.id";
$insertUserInfoSQL = 
    "INSERT into user
    (id, email, password, nickname, type, shop_id) 
    values(NULL, :email, :password, :nickname, 1, null)";
$updateUserInfoNonPassSQL = 
    "UPDATE user SET
        email = :email
        , nickname = :nickname
     WHERE id = :id";
$updateUserInfoSQL = 
    "UPDATE user SET
        email = :email
        , nickname = :nickname
        , password = :password
     WHERE id = :id";
$updateUserInfoNonPassForAdminSQL = 
    "UPDATE user SET
        email = :email
        , nickname = :nickname
        , shop_id = :shop_id
        , type = :authority
     WHERE id = :id";
$updateUserInfoForAdminSQL = 
    "UPDATE user SET
        email = :email
        , nickname = :nickname
        , shop_id = :shop_id
        , type = :authority
        , password = :password
     WHERE id = :id";
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
$deleteUserSQL = 
    "UPDATE user SET
        del_flg = 1
     WHERE id = :id";
$getShopListSQL = 
    "SELECT
    id
    , shop_name
    FROM shop
    ORDER BY id";
$getKbnListSQL = 
    "SELECT
    id
    , text
    , value
    FROM kbn
    WHERE cd = :cd
    ORDER BY id";

?>