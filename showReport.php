<?php

include './base/base.php';

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

        <?php
            // 投稿数読み込み
            $fp = fopen($cntFilePath, "r");
            flock($fp, LOCK_SH);

            $reportCnt = fgets($fp);

            flock($fp, LOCK_UN);
            fclose($fp);
        ?>

            <div class="subheader clearfix">
                <h2>○○農家の買いレポ＆食レポ</h2>
                <p>投稿数:<?=$reportCnt?></p>
                <a href="./index.php">投稿する</a>
            </div>

       <?php
            // 投稿複数表示
            for($s = $reportCnt; $s > $reportCnt -3 ; $s--) {
        ?>

            <?php
                // 投稿コメント読み込み
                if(file_exists("$baseDataDirPath/$s/input.txt")) {

                    $fp = fopen("$baseDataDirPath/$s/input.txt", "r");
                    flock($fp, LOCK_SH);

                    for($i = 0; $i < 8 ; $i++) {
                        switch($i) {
                            case 0:
                                $date = substr(fgets($fp), 2);
                                continue 2;
                            case 1:
                                $place = substr(fgets($fp), 2);
                                continue 2;
                            case 2:
                                $name = substr(fgets($fp), 2);
                                continue 2;
                            case 3:
                                $repeatEvl = substr(fgets($fp), 2);
                                continue 2;
                            case 4:
                                $priceEvl = substr(fgets($fp), 2);
                                continue 2;
                            case 5:
                                $buyPdt = substr(fgets($fp), 2);
                                continue 2;
                            case 6:
                                $price = substr(fgets($fp), 2);
                                continue 2;
                            case 7:
                                $tmpImpression = substr(fgets($fp), 2);
                                continue 2;
                        }
                    }

                    flock($fp, LOCK_UN);
                    fclose($fp);

                    // 写真読み込み
                    if(is_dir("$baseUploadDirPath/$s")) {
                        $fileArray = array();
                        $handle = opendir("$baseUploadDirPath/$s");
                        while(false !== ($entry = readdir($handle))) {
                            if( $entry != '.' && $entry != '..') {
                                array_push($fileArray, $entry);
                            }
                        }
                        closedir($handle);
                    }
                ?>

        <div id="outputReport">
            <p>投稿日：<?=$date?></p>
            <p>写真:
                <?php
                    echo "<img src=\"$baseUploadDirPath/$s/$fileArray[0]\">";
                ?></p>
            <p>ニックネーム:<?=$name?></p>
            <p>購入場所:<?=getPlaceText($place)?></p>
            <p>リピート:<?=getRepeatEvlText($repeatEvl)?></p>
            <p>お値段:<?=getPriceEvlText($priceEvl)?></p>
            <p>購入商品:<?=$buyPdt?></p>
            <p>購入金額:<?=$price?></p>
            <p>感想:<?=$tmpImpression?></p>

            <?php
                } else {
                    break;
                }
            ?>


        </div>
       <?php
            }
        ?>
    </body>
</html>
