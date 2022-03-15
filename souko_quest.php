<?php
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/get_post_check.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>倉庫クエアップデート</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main">
        <table>
            <tr>
                <th>
                    <h2>倉庫クエ<?= $step; ?>（敵一覧）データ</h2>
                </th>
            </tr>
        </table>
        <p>
<?php
try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (empty($search)) {
       $sql = 'SELECT * FROM souko_kue WHERE step = ?';
       $stmt = $dbh->prepare($sql);
       $stmt->bindValue(1, $step, PDO::PARAM_INT);
    } elseif (isset($search)) {
        for ($i = 0; $i < count($drop_item_name); $i++) {
            if (preg_match('/'.$search.'/', $drop_item_name[$i])) {
                $cnt = $i;
                break;
            }
        }
        $sql = 'SELECT * FROM souko_kue WHERE step = ? and (drop_item = ? or drop_enemy like ? or drop_area1 like ? or drop_area2 like ?)';
        $search_like = '%' . $search . '%';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $step, PDO::PARAM_INT);
        if (isset($cnt)) {
            $stmt->bindValue(2, $cnt, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(2, NULL, PDO::PARAM_INT);
        }
        $stmt->bindValue(3, $search_like, PDO::PARAM_STR);
        $stmt->bindValue(4, $search_like, PDO::PARAM_STR);
        $stmt->bindValue(5, $search_like, PDO::PARAM_STR);
    }
    //echo $sql . '<br>';
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($result);
    //var_dump($search);
    echo '<table>' . PHP_EOL;
    echo '<tr>' . PHP_EOL;
    echo '<th>' . PHP_EOL;
    echo '<form method="get" action="souko_quest.php?step=' . htmlspecialchars($step, ENT_QUOTES) . '&search=' . htmlspecialchars($search, ENT_QUOTES) . '">' . PHP_EOL;
    echo '<input type="text" class="search_id" name="search" value="' . htmlspecialchars($search, ENT_QUOTES) . '" size="22" maxlength="10">' . PHP_EOL;
    echo '<input type="hidden" name="step" value="' . htmlspecialchars($step, ENT_QUOTES) .'">' . PHP_EOL;
    echo '<input type="submit" value="検索">' . PHP_EOL;
    echo '<button class="reset"">リセット</button>' . PHP_EOL;
    echo '</form>' . PHP_EOL;
    echo '</th>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
    echo '</table>' . PHP_EOL;
    echo '<table border="1">' . PHP_EOL;
    echo '<tr>' . PHP_EOL;
    echo '<th>ドロップアイテム</th><th>ドロップする敵</th><th>エリア１</th><th>エリア２</th><th>座標(付近)</th>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
    foreach ($result as $row) {
        //var_dump($row);
        echo '<tr>' . PHP_EOL;
        echo '<td>' . $drop_item_name[(int)$row['drop_item']] . '</td>' . PHP_EOL;
        echo '<td>' . htmlspecialchars($row['drop_enemy']) . '</td>' . PHP_EOL;
        echo '<td>' . htmlspecialchars($row['drop_area1']) . '</td>' . PHP_EOL;
        echo '<td>' . htmlspecialchars($row['drop_area2']) . '</td>' . PHP_EOL;
        echo '<td>(' . htmlspecialchars($row['x'], ENT_QUOTES) . ',' . htmlspecialchars($row['y'], ENT_QUOTES) . ')↑' . htmlspecialchars($row['height'], ENT_QUOTES) . '</td>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
    }
    echo '</table>' . PHP_EOL;
    $dbh = null;
} catch (PDOException $e) {
    echo 'エラー発生：表示に失敗しました。';
    exit;
}
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
        </p>
    </div>
	<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/souko_quest.js"></script>
</body>
</html>