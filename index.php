<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 24.11.2017
 * Time: 13:27
 */

require_once('application/models/database/database_connection.php');
require_once('application/models/objects/user.php');
require_once('application/models/object_mng_impl/user_mng.php');
require_once('application/models/objects/score.php');
require_once('application/models/object_mng_impl/score_mng.php');
require_once('application/models/objects/comment.php');
require_once('application/models/object_mng_impl/comment_mng.php');
require_once('application/models/objects/article.php');
require_once('application/models/object_mng_impl/article_mng.php');

function dump($what){
    echo '<pre>';
    if ($what == null){
        echo 'NULL RETURNED';
    } else {
        print_r($what);
    }
    echo '</pre>';
}

$db = new database_connection();
/*
$user = new user("vlad","malynych","vladmailcom","vlad_malynych","vlad09021996");
$userManager = new user_mng();

dump($userManager->create_user($user));
$user->setName("oleg");
dump($userManager->update_user($user));
dump($userManager->find_user_by_username($user->getUsername()));
$userManager->delete_user_by_id(3);
dump($userManager->find_all_users());

echo '/////////////////////////////////////////////////';

$comment = new comment(1,1,"HElllo there", 0);

$commentManager = new comment_mng();
$test = $commentManager->create_comment($comment);
dump($test);
$test->setPoints(6);
$test->setContent('Bye Therre');
dump($commentManager->update_comment($test));
dump($commentManager->find_comments_by_article_id_for_user_id(1,1));
dump($commentManager->find_all_comments());
dump($commentManager->find_comments_by_article_id(1));
dump($commentManager->find_comments_by_user_id(1));

echo '/////////////////////////////////////////////////';

$score = new score(2,2,7);
$scoreManager = new score_mng();
$score_test = $scoreManager->create_score($score);
dump($score_test);
$score->setId($score_test->getId());
$score->setPoints(3);
dump($scoreManager->update_score($score));
dump($scoreManager->find_all_scores());
dump($scoreManager->find_score_by_id($score->getId()));
dump($scoreManager->find_score_by_article_user_id(2,2));

echo '/////////////////////////////////////////////////';
*/
$article = new article(1,"lion", "dangerous lion", true);

$articleManager = new article_mng();
//$article_test = $articleManager->create_article($article);
//dump($article_test);
//$article->setContent("small furry penguins");
//$article->setId(2);
//$article->setStatus(false);
//$article->setName("small penguins");
//dump($articleManager->update_article($article));
dump($articleManager->find_all_articles());
//dump($articleManager->find_articles_by_name("small penguins"));
$test = $articleManager->find_article_by_id(2);
//$test = $articleManager->find_articles_by_status(false);
echo ($test->getStatus()) ? 'true' : 'false';