<?php

include './base/base.php';

$place = $_POST["place"];
$name = htmlEnc($_POST["name"]);
$repeatEvl = $_POST["repeatEvl"];
$priceEvl = $_POST["priceEvl"];
$buyPdt = htmlEnc($_POST["buyPdt"]);
$price = $_POST["price"];
$impression = htmlEnc($_POST["impression"]);

$uploadFilePath;
$reportCnt;

// 投稿数カウント処理
if (file_exists($cntFilePath)) {

    $fp = fopen($cntFilePath, "r");
    flock($fp, LOCK_SH);

    $reportCnt = fgets($fp) + 1;

    flock($fp, LOCK_UN);
    fclose($fp);

    $fp = fopen($cntFilePath, "w");
    flock($fp, LOCK_EX);

    fwrite($fp, $reportCnt);

    flock($fp, LOCK_UN);
    fclose($fp);

} else {
    $reportCnt = 1;
    $file = fopen($cntFilePath, "a");
    flock($file, LOCK_EX);
    fputs($file, $reportCnt);
    flock($file, LOCK_UN);
    fclose($file);
}

// ファイルアップロード処理
if($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $uploadName = $_FILES["photo"]["name"];
    mkdir("$baseUploadDirPath/$reportCnt", 0755);
    $path_parts = pathinfo($uploadName);

    $uploadFilePath = "$baseUploadDirPath/$reportCnt/1.$path_parts[extension]";

    if(move_uploaded_file($tmp_name, $uploadFilePath)) {
//        echo "upload OK";
    } else {
        echo "upload NG";
    }
}

// コメント保存処理
mkdir("$baseDataDirPath/$reportCnt", 0755);
$file = fopen("$baseDataDirPath/$reportCnt/input.txt","a");
flock($file, LOCK_EX);

fwrite($file, '0:'.date("n月j日 G時i分")."\n");
fwrite($file, '1:'.$place."\n");
fwrite($file, '2:'.$name."\n");
fwrite($file, '3:'.$repeatEvl."\n");
fwrite($file, '4:'.$priceEvl."\n");
fwrite($file, '5:'.$buyPdt."\n");
fwrite($file, '6:'.$price."\n");
$tmpImpression = str_replace(array("\r\n","\n","\r"),"", nl2br($impression));
fwrite($file, '7:'.$tmpImpression);

flock($file, LOCK_UN);
fclose($file);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>キョウココ</title>
        <link rel="stylesheet" href="css/main.css">
        <script src="./lib/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <header>
           <h1>
               キ ョ ウ コ コ
           </h1>
        </header>
        <div class="subheader clearfix">
                <h2>○○農家の買いレポ＆食レポ</h2>
                <a href="./index.php">投稿する</a><br>
                <a href="./showReport.php">投稿を見る</a>
        </div>
        <div id="inputReport">
            <p>写真:<?php
                if($_FILES['photo']) {
                }
                ?>
                <?php
                    echo "<img src=\"$uploadFilePath\">";
                ?></p>
            <p>ニックネーム:<?=$name?></p>
            <p>購入場所:<?=getPlaceText($place)?></p>
            <p>リピート:<?=getRepeatEvlText($repeatEvl)?></p>
            <p>お値段:<?=getPriceEvlText($priceEvl)?></p>
            <p>購入商品:<?=$buyPdt?></p>
            <p>購入金額:<?=$price?> 円</p>
            <p>感想:<?=$tmpImpression?></p>
        </div>
    </body>
</html>
