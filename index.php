<?php
session_start();

define('APP_HTTP', 'http://localhost:63342/5milprojet');
define('APP', dirname(__FILE__));

require APP . '/view/_partials/header.php';
require APP . '/view/_partials/navigation.php';

if(!isset($_GET["action"])) {
    require 'view/home.php';
}
else {
    switch ($_GET['action']) {
        case 'login':
            require 'view/login.php';
            break;
        case 'register':
            require 'view/register.php';
            break;
        case 'logout':
            require 'view/logout.php';
            break;
        case 'article':
            if(isset($_GET['id'])) {
                require APP . '/model/DB.php';
                require APP . '/model/Article.php';
                $articleId = intval($_GET['id']); //TODO: explication de intval?

                // Loading selected article.
                $article = new Article();
                $article->setId($articleId);
                $article->loadData(DB::getDbLink());
                require 'view/article.php';
            }
            break;
        case 'comment': //TODO: commentaire vide!
            if(isset($_GET['article']) && isset($_GET['user']) && isset($_POST['commentaire'])) {
                if(!empty($_POST['commentaire'])) {
                    require APP . '/model/DB.php';
                    require APP . '/model/Comment.php';
                    $comment = new Comment();
                    $comment->setUser(intval($_GET['user']))
                        ->setArticleId(intval($_GET['article']))
                        ->setTextContent($_POST['commentaire']);
                    $comment->insert(DB::getDbLink());

                }
            }
            header('Location: ' . APP_HTTP . '/?action=article&id=' . intval($_GET['article']));
            break;

        case 'article-add':
            if(isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'ADMIN') {
                require 'view/admin/article-add.php';
            }
            break;
        default:
            require 'view/home.php';
            break;
    }
}


require APP . '/view/_partials/footer.php';