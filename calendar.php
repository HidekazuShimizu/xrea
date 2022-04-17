<?php
// 祝日の読み込み
require_once __DIR__ . '/holiday_require.php';

// タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    $ym = date('Y-m');
}

// タイムスタンプを作成して、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 今月の月を表示
$data = explode('-', $ym);
$m = $data[1];

// 今日の日付フォーマット　例）2022-04-1
$today = date('Y-m-j');

// カレンダーのタイトルを作成　例）2022年4月
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
// strtotimeを使う
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か　0:日　1:月　2:火　...　6:土
$youbi = date('w', $timestamp);

// カレンダー作成の準備
$weeks = [];
$week = '';
$holiday_count = 0;     // 祝日用カウンター　例）0:日曜以外 1:日曜

// 第１週目：空のセルを追加
// 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {
    // 2022-04-1
    $date = $ym . '-' . $day;
    // 04-1
    $date2 = $m . '-' . $day;

    if ($today == $date) {
        // 祝日が日曜の場合
        if ($youbi % 7 == 0 && isset($holiday[$date2])) {
            $week .= '<td class="today"><p title="' . $holiday[$date2] . '">' . $day . "</p>";
            $holiday_count = 1;
        } elseif (isset($holiday[$date2])) {
            // 祝日の場合は、<font color="red"> ～ </font>で囲む
            $week .= '<td class="today"><font color="red"><p title="' . $holiday[$date2] . '">' . $day . "</p></font>";
        } elseif ($youbi % 7 == 1 && $holiday_count == 1) {
            // 祝日が日曜の場合、振替休日を設ける
            // 振替休日は、<font color="red"> ～ </font>で囲む
            $week .= '<td class="today"><font color="red"><p title="振替休日">' . $day . "</p></font>";
            $holiday_count = 0;
        } else {
            $week .= '<td class="today">' . $day;
        }

        if ($youbi % 7 == 1 && $holiday_count == 1) {
        }
    } elseif (isset($holiday[$date2])) {
        // 祝日が日曜の場合
        if ($youbi % 7 == 0) {
            $week .= '<td><p title="' . $holiday[$date2] . '">' . $day . "</p>";
            $holiday_count = 1;
        } else {
            // 祝日の場合は、<font color="red"> ～ </font>で囲む
            $week .= '<td><font color="red"><p title="' . $holiday[$date2] . '">' . $day . "</p></font>";
        }
    } else {
        // 祝日が日曜の場合、振替休日を設ける
        if ($youbi % 7 == 1 && $holiday_count == 1) {
            // 振替休日は、<font color="red"> ～ </font>で囲む
            $week .= '<td><font color="red"><p title="振替休日">' . $day . "</p></font>";
            $holiday_count = 0;
        } else {
            $week .= '<td>' . $day;
        }
    }
    $week .= '</td>';

    // 週終わり、または、月終わりの場合
    if ($youbi % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            // 月の最終日の場合、空セルを追加
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>完美世界～ぱたぱたままの小屋～`</title>
	<link rel="icon" href="img/favicon.ico">
	<link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <style>
        .container {
            font-family: 'Noto Sans Jp', sans-serif;
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
        }
        .today {
            background-color: orange !important;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="mb-5"><a href="?ym=<?= $prev; ?>">&lt;</a> <?= $html_title; ?> <a href="?ym=<?= $next; ?>">&gt;</a></h3>
        <table class="table tabule-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week . PHP_EOL;
                }
            ?>
        </table>
        <table class="table tabule-bordered">
            <tr>
                <th>
                    <form method="post" action="index.html">
                        <input type="submit" value="戻る">
                    </form>
                </th>
            </tr>
        </table>
    </div>
</body>
</html>