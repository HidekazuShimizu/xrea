<?php
// DB接続用ファイルとGETとPOSTの値をチェックするファイルを読み込み
require_once __DIR__ . '/../db_config.php';
require_once __DIR__ . '/../get_post_check.php';

if ($_POST['id'] == NULL) {
    echo "正しい更新ボタンを押してください。";
    exit;
}

try {
    // DB接続開始
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM souko_kue WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 各種パラメータの設定（idから取得）
    $drop_item = (int)$result['drop_item'];
    $drop_enemy = htmlspecialchars($result['drop_enemy'], ENT_QUOTES);
    $drop_area1 = htmlspecialchars($result['drop_area1'], ENT_QUOTES);
    $drop_area2 = htmlspecialchars($result['drop_area2'], ENT_QUOTES);
    if ($result['x'] || $result['x'] == "0") {
        $x = (int)$result['x'];
    } else {
        $x = NULL;
    }
    if ($result['y'] || $result['y'] == "0") {
        $y = (int)$result['y'];
    } else {
        $y = NULL;
    }
    if ($result['height'] || $result['height'] == "0") {
        $height = (int)$result['height'];
    } else {
        $height = NULL;
    }

    // DB領域の開放
    $dbh = null;
} catch (PDOException $e) {
    echo 'エラー発生：更新処理に失敗しました。';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>倉庫クエアップデート</title>
	<link rel="icon" href="../img/favicon.ico">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="main">
    <h2>倉庫クエ（敵一覧）データ更新</h2>
    <form method="post" action="update_souko_kue2.php?step=<?= htmlspecialchars($step, ENT_QUOTES) ?>">
<?php
// データ表示
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>ドロップアイテム</th><th>ドロップする敵</th><th>エリア１</th><th>エリア２</th><th>x座標</th><th>y座標</th><th>高度</th><th>更新</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<td>' . PHP_EOL;
echo '<select name="drop_item">' . PHP_EOL;
echo '<option value="NULL">選択してください</option>' . PHP_EOL;
foreach ($drop_item_name as $key => $value) {
    echo '<option value="' . $key . '"';
    if ($key == $drop_item) {
        echo ' selected';
    }
    echo '>' . $value .'</option>' . PHP_EOL;
}
echo '</select>' . PHP_EOL;
echo '</td>' . PHP_EOL;
echo '<td><input type="text" name="drop_enemy" value="' . $drop_enemy . '" size="20" maxlength="10" required></td>' . PHP_EOL;
echo '<td><input type="text" name="drop_area1" value="' . $drop_area1 . '" size="10" maxlength="10"></td>' . PHP_EOL;
echo '<td><input type="text" name="drop_area2" value="' . $drop_area2 . '" size="10" maxlength="10"></td>' . PHP_EOL;
echo '<td><input type="text" name="x" value="' . $x . '" size="3" maxlength="3"></td>' . PHP_EOL;
echo '<td><input type="text" name="y" value="' . $y . '" size="3" maxlength="3"></td>' . PHP_EOL;
echo '<td><input type="text" name="height" value="' . $height . '" size="3" maxlength="3"></td>' . PHP_EOL;
echo '<td><input type="submit" value="更新"></td>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '<input type="hidden" name="id" value="' . $id . '">';
?>
    </form>
    <table>
        <tr>
            <th>
                <form method="post" action="souko_kue.php?step=<?= htmlspecialchars($step, ENT_QUOTES) ?>">
                    <input type="submit" value="戻る">
                </form>
            </th>
        </tr>
    </table>
    </div>
</body>
</html>