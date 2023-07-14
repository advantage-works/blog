<?php
declare(strict_types = 1);
$rootDirectry = mb_strstr(dirname(__FILE__), "blogtest", true);
include_once $rootDirectry . "blogtest/library/include.php";

//メソッドチェック
checkMethodIsGet();

//パラメータ数チェック
checkPostGet($_POST, $_GET, "0", "0");

$pdo = dbconnect();
$categoryStatement = $pdo->prepare("select * from category");
$categoryStatement->execute();
$newArticleStatement = $pdo->prepare("select id, title, summary from article order by update_date desc limit 6");
$newArticleStatement->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<?php getHead("トップ"); ?>

<body>
    <?php getHeader(); ?>    
    <article>
        <div class="title">
            <h2>ようこそAdvantage ITへ</h2>
        </div>
        <div class="main-image">
            <p>ここにそれっぽい画像を入れようと思います。</p>
        </div>
        
        <div class="contents-body">
            <section>
                <div class="site-summary">
                    <h3>当サイト概要</h3>
                    <div class="section-body">
                        <p>IT、特にプログラミングを学習する中で気づいたことを備忘録的に書いたブログ。</p>
                        <p>初心者から学習するプロセスを書いているので、熟練のプログラマの方にはお見苦しいかもしれない。</p>
                        <p>プログラミングを学習しようとする人が同じことで無駄に煮詰まらないことを願い、また書き出すことで自身の理解を深める目的があります。</p>
                    </div>
                    
                </div>
            </section>
            <section>
                <div class="category-list">
                    <h3>カテゴリ一覧</h3>
                    <div class="section-body">
                        <ul>
                            <div class="category-wrapper">
                            
                                <?php while ($categoryData = $categoryStatement->fetch(PDO::FETCH_ASSOC)) { ?>
                                <a href="<?=getUrl()?>articlelist/?categoryId=<?=$categoryData["id"]?>">
                                    <li>
                                        <div class="category-body">
                                            <h3><?=validate($categoryData["categoryName"])?></h3>
                                            <p><?=validate($categoryData["categoryExplanation"])?></p>
                                        </div>
                                    </li>
                                </a>
                                <?php } ?>
                            
                            </div>
                        </ul>
                    </div>
                      
                </div>
            </section>
            <section>
                <div class="new-article">
                    <h3>新着記事</h3>
                    <div class="section-body">
                        <ul class="article-list">
                            <div class="article-wrapper">
                                <?php while($articleData = $newArticleStatement->fetch(PDO::FETCH_ASSOC)) {?>
                                <a href="<?=getUrl()?>article/?articleId=<?=$articleData["id"]?>">
                                    <li>
                                        <div class="article-body">
                                            <h3><?=validate($articleData["title"])?></h3>
                                            <p><?=cleanTag($articleData["summary"])?></p>
                                        </div>
                                    </li>
                                </a>
                                <?php } ?>
                            </div>
                        </ul>
                    </div>
                    
                </div>
            </section>
            <?php getProfile(); ?>
        </div>
    </article>
    <?php getFooter(); ?>
</body>
</html>