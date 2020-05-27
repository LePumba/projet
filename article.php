<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
$_SESSION['userId'] = 1;

require 'Model/DB.php';
require 'Model/User.php';
require 'Model/Comment.php';
require 'Model/Article.php';


function displayArticle($article)
{?>
   <div class="article">
       <h1 class="article-title"><?= $article->getTitle(); ?></h1>
       <span class="article-author"><?= $article->getUser(DB::getDbLink())->getUsername(); ?></span>
       <p class="article-content">
            <?= $article->getContent(); ?>
       </p><?php

       foreach($article->fetchComments(DB::getDbLink()) as $comment) { ?>
           <span class="comment-author"><?= $comment->getUser(DB::getDbLink())->getUsername(); ?></span>
           <div class="comment-content"><?= $comment->getTextContent(); ?></div>
       <?php
       } ?>
       <div class="article-comments">

       </div>

   </div> <?php
}

