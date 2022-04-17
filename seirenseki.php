<?php
// 定数ISHIを設定（設定値12）
const ISHI = 12;

// POSTされた配列の合計値が定数ISHIと同じであれば、$num配列に値を入れていく
if (count($_POST) === ISHI) {
    foreach ($_POST as $key => $value){
        if ($key > ISHI) { break; }
        $num[$key] = $value;
    }
} else {
    // 計算前の精錬石の初期値を入れる
    for ($i = 0; $i < ISHI; $i++) {
        $num[$i] = 0;
    }
}

// 計算後の精錬石の初期値を入れる
for ($i = 0; $i < ISHI; $i++) {
    $calcNum[$i] = 0;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>完美世界～ぱたぱたままの小屋～`</title>
	<link rel="icon" href="img/favicon.ico">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main">
    <table>
        <tr>
            <th>
                <h2>精錬石シミュレーター</h2>
            </th>
        </tr>
    </table>
    <p>
<?php
// 精錬石1～12を作るための精錬石
$lv[1]  = 1;
$lv[2]  = $lv[1] * 4;
$lv[3]  = $lv[1] * 2    + $lv[2] * 2;
$lv[4]  = $lv[1] * 1    + $lv[2] * 1    + $lv[3] * 2;
$lv[5]  = $lv[4] * 2    + $lv[3] * 1;
$lv[6]  = $lv[5] * 2    + $lv[3] * 1;
$lv[7]  = $lv[6] * 1    + $lv[5] * 1    + $lv[4] * 1;
$lv[8]  = $lv[7] * 1    + $lv[6] * 1    + $lv[5] * 1;
$lv[9]  = $lv[8] * 1    + $lv[7] * 1    + $lv[6] * 1;
$lv[10] = $lv[9] * 1    + $lv[8] * 1    + $lv[7] * 1;
$lv[11] = $lv[10] * 1   + $lv[9] * 1    + $lv[8] * 1;
$lv[12] = $lv[11] * 1   + $lv[10] * 1   + $lv[9] * 1;

// 精錬石1～12の画像ファイル名を保存
$lvStone = [
    'lv1.png',
    'lv2.png',
    'lv3.png',
    'lv4.png',
    'lv5.png',
    'lv6.png',
    'lv7.png',
    'lv8.png',
    'lv9.png',
    'lv10.png',
    'lv11.png',
    'lv12.png', 
];

// 計算前のテーブル
echo '<h3>計算前</h3>';
echo '<form method="post" action="seirenseki.php">' . PHP_EOL;
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>1石</th><th>2石</th><th>3石</th><th>4石</th><th>5石</th><th>6石</th>' . PHP_EOL;
echo '<th>7石</th><th>8石</th><th>9石</th><th>10石</th><th>11石</th><th>12石</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;

// ループさせて、精錬石の画像を設定していく
foreach ($lvStone as $value) {
    echo '<td><img src="img/' . $value .'"></td>' . PHP_EOL;
}

echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;

// ループさせて、入力されていた石の数を反映させる
foreach ($num as $key => $value) {
    echo '<td><input type="number" class="reset_place" name="' . $key .'" value="' . $value . '" min="0" max="99">' . PHP_EOL;
}

echo '</tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '<input type="submit" value="計算"><button class="reset">リセット</button>' . PHP_EOL;

// 計算後のテーブル
echo '<h3>計算後</h3>';
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>1石</th><th>2石</th><th>3石</th><th>4石</th><th>5石</th><th>6石</th>' . PHP_EOL;
echo '<th>7石</th><th>8石</th><th>9石</th><th>10石</th><th>11石</th><th>12石</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;

// ループさせて、精錬石の画像を設定していく
foreach ($lvStone as $value) {
    echo '<td><img src="img/' . $value .'"></td>' . PHP_EOL;
}

echo '<td></td>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;

// 計算 ////////////////////
// 計算に使う変数の初期化
$calculator = 0;

// 計算した結果を変数に入れていく
foreach ($num as $key => $value) {
    if ($value) {
        $calculator += $lv[$key + 1] * $value;
    }
}

// 無限ループ発生
while (1) {
    // 変数が、精錬石LV12より特段に大きい時用の処理
    // 変数が精錬石LV12より大きいとき、変数を精錬石LV12を作るのに必要な精錬石LV1の数だけ引き算を行って、
    // その分、計算結果の対応するLVの石に1を加算し、条件を満たしたなら、またループの初めから処理を行う
    if ($calculator >= $lv[count($num)]) {
        $calculator -= $lv[count($num)];
        $calcNum[count($num) - 1] += 1;
        continue;
    }

    // 変数が、精錬石LV？と精錬石LV？-1に挟まれる数の時用の処理
    // 変数が精錬石LV？より小さく、精錬石LV？-1より大きいか同じときに、変数から精錬石？-1の石の数だけ引き算を行い、
    // その分、計算結果の対応するLVの石に1を加算する
    for ($i = count($num); $i > 1; $i--) {
        if ($calculator < $lv[$i] && $calculator >= $lv[$i - 1]) {
            $calculator -= $lv[$i - 1];
            $calcNum[$i - 2] += 1;
        }
    }

    // 変数が0以下になったら、ループを抜ける
    if ($calculator <= 0) {
        break;
    }
}

// 計算結果の各LV石の数を表示していく
foreach ($calcNum as $key => $value) {
    echo '<td><input type="number" class="reset_place" name="calcNum[' . $key .']" value="' . $value . '" min="0" max="999" disabled></td>' . PHP_EOL;
}
echo '</tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '</form>';

?>
        <table>
            <tr>
                <th>
                    <form method="post" action="index.html">
                        <input type="submit" value="戻る">
                    </form>
                </th>
            </tr>
        </table>
        ※あくまで、1石が何個で12石等作れるかを判定しているβ版です。そこのところよろしくお願いいたします。
        </p>
    </div>

    <!--Scripts-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/souko_quest.js"></script>
</body>
</html>