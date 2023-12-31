<?php
declare(strict_types = 1);
$rootDirectry = mb_strstr(dirname(__FILE__), "blogtest", true);
include_once $rootDirectry . "blogtest/library/include.php";

//メソッドチェック
checkMethodIsGet();

//パラメータ数チェック
checkPostGet($_POST, $_GET, "0", "0");

session_start();

//loginstatusが存在しない場合、終了
if (!isset($_SESSION["loginstatus"])) {
    deleteSession();
    header("Location: login.php");
    exit();
}

//ログインステータスが1でない、または指定時間経過でログイン画面へ
if ($_SESSION["loginstatus"] != 1 || time() - $_SESSION["time"] > getTimeoutSecond()) {
    deleteSession();
    header("Location: login.php");
    exit();
}
//タイムアウト時間更新
$_SESSION["time"] = time();

$pdo = dbconnect();

//記事一覧を取得、一覧用とプルダウン用
$articleStatementForList = $pdo->prepare("select title from article");
$articleStatementForList->execute();
$articleStatementForPulldown = $pdo->prepare("select id, title from article");
$articleStatementForPulldown->execute();
?>
<!DOCTYPE html>
<html lang="ja">
<?php getHead("カテゴリ編集"); ?>

<body>
    <?php getAdminHeader(); ?>
    <article>
            
        <div class="title">
            <h2>カテゴリ編集</h2>
        </div>
        <div class="contents-body">
            <section>
                <h3>既存の記事</h3>
                <div class="section-body">
                    <ul>
                        <?php while($article = $articleStatementForList->fetch(PDO::FETCH_ASSOC)){ //カテゴリ一覧を出力?>
                        <li><?=validate($article["title"])?></li>
                        <?php } ?>
                    </ul>
                </div>
            </section>
            <section>
                <h3>これから編集する記事</h3>
                <div class="section-body">
                    <form name="article" action="editarticle.php" method="post">
                        <select name="editArticleId">
                            <?php while($article = $articleStatementForPulldown->fetch(PDO::FETCH_ASSOC)){ //カテゴリ一覧を出力?>
                            <option value="<?=$article["id"]?>"><?=validate($article["title"])?></option>
                            <?php } ?>
                        </select>
                        <button type="submit">編集画面へ</button>  
                    </form>
                </div>
            </section>
        </div>
    </article>
    <?php getFooter(); ?>
</body>
</html>