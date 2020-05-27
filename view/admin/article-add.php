<?php
require APP . '/model/DB.php';
require APP . '/model/Article.php';
?>

<div class="container">
    <h1>Ajouter un article</h1>
    <form action="<?= APP_HTTP ?>/?index.php&action=article-add" method="POST">
        <label for="title" class="form-control">Titre</label>
        <input type="text" class="form-control" placeholder="Titre de l'article" name="title" id="title"/>
        <label for="content" class="form-control">Contenu de votre article</label>
        <textarea name="content" id="content" cols="50" rows="20" class="form-control"></textarea>
        <input type="submit" value="Enregistrer" class="form-control" name="submit" id="submit">
    </form>
</div>

<?php
if(isset($_POST['submit']) && isset($_POST['content']) && isset($_POST['title'])) {
    $article = new Article();
    $article->setUser(intval($_SESSION['userID']))
            ->setTitle(htmlentities($_POST['title']))
            ->setContent(htmlentities($_POST['content']));
    if($article->insert(DB::getDbLink())) {
        echo "Ajouté avec succès";
    }
}

