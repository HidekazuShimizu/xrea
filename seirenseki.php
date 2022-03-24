<?php
const ISHI = 12;

//print_r($_POST) . '<br>';
if (count($_POST) >= ISHI) {
    foreach ($_POST as $key => $value){
        if ($key > ISHI) { break; }
        $num[$key] = $value;
    }
} else {
    for ($i = 0; $i < ISHI; $i++) {
        $num[$i] = 0;
    }
}
//var_dump($num);
foreach ($_POST as $key => $value) {
    $calcNum[$key] = 0;
}
//var_dump($calcNum);
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
// 精錬石2～12を作るための精錬石
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

//echo $lv[12];

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

echo '<h3>計算前</h3>';
echo '<form method="post" action="seirenseki.php">' . PHP_EOL;
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>1石</th><th>2石</th><th>3石</th><th>4石</th><th>5石</th><th>6石</th>' . PHP_EOL;
echo '<th>7石</th><th>8石</th><th>9石</th><th>10石</th><th>11石</th><th>12石</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;
foreach ($lvStone as $value) {
    echo '<td><img src="img/' . $value .'"></td>' . PHP_EOL;
}
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;
foreach ($num as $key => $value) {
    echo '<td><input type="number" class="reset_place" name="' . $key .'" value="' . $value . '" min="0" max="99">' . PHP_EOL;
}
echo '</tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '<input type="submit" value="計算"><button class="reset">リセット</button>' . PHP_EOL;

echo '<h3>計算後</h3>';
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>1石</th><th>2石</th><th>3石</th><th>4石</th><th>5石</th><th>6石</th>' . PHP_EOL;
echo '<th>7石</th><th>8石</th><th>9石</th><th>10石</th><th>11石</th><th>12石</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;
foreach ($lvStone as $value) {
    echo '<td><img src="img/' . $value .'"></td>' . PHP_EOL;
}
echo '<td></td>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;

// 計算
$calculator = 0;
foreach ($num as $key => $value) {
    if ($value) {
        $calculator += $lv[$key + 1] * $value;
    }
}
//var_dump($calculator);
while (1) {
//echo 'lv12? = ' . $lv[count($num)] . '<br>';
    if ($calculator >= $lv[count($num)]) {
        $calculator -= $lv[count($num)];
        $calcNum[count($num) - 1] += 1;
        continue;
    }
    for ($i = count($num); $i > 1; $i--) {
//echo 'calc = ' . $calculator . ' : lv' . ($i) . ' = ' . $lv[$i] . ' : caclNum['. $i . '] = ' .(int)$calcNum[$i - 1] . '<br>';
        if ($calculator < $lv[$i] && $calculator >= $lv[$i - 1]) {
//echo 'calc2 = ' . $calculator . ' : lv' . ($i) . ' = ' . $lv[$i] . ' : caclNum['. $i . '] = ' .(int)$calcNum[$i - 1] . '<br>';
            $calculator -= $lv[$i - 1];
            $calcNum[$i - 2] += 1;
        }
    }
    if ($calculator <= 0) {
        break;
    }
}
//echo 'calculator = ' . $calculator . '<br>';
//var_dump($calculator);
//echo $lv[1] . ':' . $lv[2] . ':' . $lv[3] . ':' . $lv[4] . ':' . $lv[5] . ':' . $lv[6] . ':';
//echo $lv[7] . ':' . $lv[8] . ':' . $lv[9] . ':' . $lv[10] . ':' . $lv[11] . ':' . $lv[12] . '<br>' . PHP_EOL;

foreach ($calcNum as $key => $value) {
    echo '<td><input type="number" class="reset_place" name="calcNum[' . $key .']" value="' . $value . '" min="0" max="99" disabled></td>' . PHP_EOL;
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