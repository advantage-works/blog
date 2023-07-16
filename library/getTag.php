<?php
declare(strict_types = 1);
//HTMLheadを表示する、引数にタイトルを取る
function getHead(string $title): void
{
    echo '<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . validate($title) . "-Advantage IT" . '</title>
    <link rel="stylesheet" href="https://advantage-works.net/blogtest/reset.css">
    <link rel="stylesheet" href="https://advantage-works.net/blogtest/style.css">
    <link rel="stylesheet" href="https://advantage-works.net/blogtest/style600.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    </head>';
}

//bodyheaderを表示する
function getHeader(): void
{
    echo '<header>
    <h1><a href="https://advantage-works.net/blogtest/">Advantage IT</a></h1>
    </header>';
}

//管理用bodyheaderを表示する
function getAdminHeader(): void
{
    echo '<header>
    <h1><a href="https://advantage-works.net/blogtest/jw76ii9s7dmy99ah9tkz/top.php">Advantage IT管理画面</a></h1>
    </header>';
}

//bodyheaderを表示する
//キャッシュされていないかどうかの確認のために時刻を入れている
function getFooter(): void
{
    echo '<footer>
    <p>コピーライト表記などのフッター建設予定地</p>
    <h1>' . date('Y-m-d H:i:s') . '</h1>
    </footer>';
}

//プロフィール欄を表示する
function getProfile(): void
{
    $pdo = dbconnect();
    $profileStatement = $pdo->prepare("select body from profile where id = 1");
    $profileStatement->execute();
    if (!($profile = $profileStatement->fetch(PDO::FETCH_ASSOC))) {
        //データを取得できないエラー
        getError("プロフィールがありません。");
    }
    echo '<div class="profile">
    <h3>プロフィール</h3>
    <div class="profile-body">'
     . cleanTag($profile["body"]) . 
    '</div>
    </div>';
}

//エラーを表示する、引数にエラーメッセージを取る
function getError(string $errorMessage): void
{
    echo '<!DOCTYPE html>
    <html lang="ja">';
    getHead("エラー-Advantage IT");
    echo  '<body>';
    getHeader();
    echo '<article>
            <div class="title">
                <h2>エラー</h2>
                <div class="contents-body">
                    <p>'. validate($errorMessage) . '</p>
                </div>
            </div>
        </article>';
    getFooter();
    echo '</body>
    </html>';
    exit();
}

//管理者用エラーを表示する、引数にエラーメッセージを取る
function getAdminError(string $errorMessage): void
{
    echo '<!DOCTYPE html>
    <html lang="ja">';
    getHead("エラー-Advantage IT");
    echo  '<body>';
    getAdminHeader();
    echo '<article>
            <div class="title">
                <h2>エラー</h2>
                <div class="contents-body">
                    <p>'. validate($errorMessage) . '</p>
                </div>
            </div>
        </article>';
    getFooter();
    echo '</body>
    </html>';
    exit();
}