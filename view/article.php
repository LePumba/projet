<?php
require APP . '/model/User.php';
require APP . '/model/Comment.php';
?>
<h2>Article:</h2>
<!--<p>Titre de l'article</p>-->
<br />

<div class="article">
    <h1><?= $article->getTitle(); ?></h1>
    <span><?= $article->getUser(DB::getDbLink())->getUsername(); ?></span>
    <span><?= $article->getCreatedAt(); ?></span>
    <!-- Affichage avec le code html -->
    <div><?= html_entity_decode($article->getContent()); ?></div>
</div>

<div class="comments">
    <h2>Commentaires:</h2><?php
    foreach($article->fetchComments(DB::getDbLink()) as $comment) { ?>
        <div class="comment">
            <p class="comment-content">
                <?= $comment->getTextContent(); ?>
            </p>
            <span class="author"></span>
            <span class="comment-date">
                <?= $comment->getDateCreated(); ?>
                <?= $comment->getUser(DB::getDbLink())->getUsername(); ?>

            </span>
        </div>
    <?php
    } ?>
    <h3>Ajouter un commentaire</h3>
    <?php
        if(!isset($_SESSION['userID']))
        {
            echo "<p>Vous devez être connecté pour poster un commentaire</p>";
        }
        else { ?>
            <form method="POST" action="<?= APP_HTTP ?>/?action=comment&article=<?= $article->getId();?>&user=<?= $_SESSION['userID'] ?>">
                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
            </form> <?php
        }
    ?>
</div>