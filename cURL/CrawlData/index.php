<?php
require_once '../includes/functions.php';

$url = 'https://vnexpress.net/thoi-su';

$content = HttpGet($url);

preg_match('~<div .* id="automation_TV1">\n<div .*?>(.+)</div>\n</div>~ius', $content, $matches);

if (!empty($matches[1])) {
    $listConent = $matches[1];
    preg_match_all(
        '~<article class="item-news item-news-common thumb-left" .*?>(.+?)</article>~ius',
        $listConent,
        $listArticle
    );
    if (!empty($listArticle[1])) {
        foreach ($listArticle[1] as $article) {
            preg_match('~<h3 class="title-news">\n<a.*? href="(.+?)" .*?>(.+?)</a>\n</h3>~ius', $article, $titleArticleArr);
            preg_match('~<p class="description">(.+?)</p>~ius', $article, $descArticleArr);
            preg_match('~<img.*?src="(.+?)">~ius', $article, $imgArticleArr);
            $desc = null;
            $title = null;
            $link = null;
            $linkImage = null;
            if (!empty($titleArticleArr[2])) {
                $title = trim($titleArticleArr[2]);
            }
            if (!empty($titleArticleArr[1])) {
                $link = trim($titleArticleArr[1]);
            }
            if (!empty($descArticleArr[1])) {
                $desc = trim($descArticleArr[1]);
            }
            if (!empty($imgArticleArr[1])) {
                $linkImage = trim($imgArticleArr[1]);
            }

            echo 'Title: ' . $title . '<br>';
            echo 'Link: ' . $link . '<br>';
            echo 'Description: ' . $desc . '<br>';
            echo 'Link Img: ' . $linkImage;
            echo '
    <hr />';
        }
    }
}