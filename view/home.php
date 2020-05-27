<!-- Masthead-->
<header class="masthead">
    <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
            <h1 class="mx-auto my-0 text-uppercase">Clefs de la Résonance</h1>
            <h2 class="text-white-50 mx-auto mt-2 mb-5">Nouveau Site</h2>
            <a class="btn btn-primary js-scroll-trigger" href="#about">C'est parti</a>
        </div>
    </div>
</header>

<!-- About-->
<section class="about-section text-center" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-white mb-4"></h2>
                <p class="text-white-50">Bonjour à tous, bienvenue sur ma chaîne 💖<br>

                    Je me prénomme Marie <br>

                    J'ai crée cette chaîne pour vous faire partager ma plus grande passion qui est l'ésotérisme, le développement personnel, la guidance, le bien être ,la spiritualité et tout ce qui ce rapporte à l'invisible.<br>

                    A travers mes ressentis, intuitions, oracles et tarots je vous fais passer des messages que l'univers me transmet pour vous.<br>

                    Vous trouverez des tirages des énergies dans diverses domaines, présentations de différents oracles, tarots , des vidéos  pour vous aidez à trouver un équilibre comme les Chakras, l'intuition, la loi d'attraction et biens d'autres!<br>

                    Pour une guidance personnalisée voici mon adresse email : clefsdelaresonanceguidance@gmail.com.</p>
            </div>
        </div>
        <img class="img-fluid" style="height: 50%;width: 50%;" src="./assets/img/Fond-blanc-texte.png" alt="" />
    </div>
</section>




<?php
require APP. '/model/DB.php';
require APP . '/model/User.php';
require APP. '/model/Comment.php';
require APP . '/model/Article.php';

$request = DB::getDbLink()->prepare("SELECT id, titre, contenu, auteur FROM actus ORDER BY id DESC");
// Si la requête s'est bien passée.
if($request->execute() && $request->bind_result($id, $title, $content, $user)) {
    $articles = array();
    while($request->fetch()) {
        $article = new Article();
        $article->setId($id)
                ->setTitle($title)
                ->setContent($content)
                ->setUser($user);
        $articles[] = $article;
    }
    $request->close();


    if(count($articles) > 0) {?>
    <section class="projects-section bg-light" id="projects">
        <div class="container">
            <!-- Featured Product, first article ( actus ) -->
            <div class="row align-items-center no-gutters mb-4 mb-lg-5">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0" src="./assets/img/bg-masthead.jpg" alt="" /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-center text-lg-left">
                        <h4><?= $articles[0]->getTitle(); ?></h4>
                        <p class="text-black-50 mb-0"><?= $articles[0]->getSummary(); ?>...</p>
                        <a class="text-blue-50 mb-0" href="<?= APP_HTTP; ?>/?action=article&id=<?= $articles[0]->getId(); ?>">Lire la suite</a>

                    </div>
                </div>
            </div>

            <!-- All other articles -->
            <?php
            // Tous sauf le premier, qui est mis en avant !
            for($i = 1; $i < count($articles); $i++) {
                $left = $i % 2 === 0;
                ?>

                <div class="row justify-content-center no-gutters <?= $left ?  "mb-5 mb-lg-0" : "" ?>">
                    <div class="col-lg-6"><img class="img-fluid" src="./assets/img/demo-image-01.jpg" alt="" /></div>
                    <div class="col-lg-6 <?= $left ? "" : " order-lg-first" ?>">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center <?= $left ? "text-lg-left" : "text-lg-right" ?>">
                                    <h4 class="text-white"><?= $articles[$i]->getTitle(); ?>...</h4>
                                    <p class="mb-0 text-white-50"><?= $articles[$i]->getSummary(); ?></p>
                                    <a class="text-blue-50 mb-0" href="<?= APP_HTTP; ?>/?action=article&id=<?= $articles[$i]->getId(); ?>">Lire la suite</a>
                                    <hr class="d-none d-lg-block mb-0 ml-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <?php
            }
            ?>
        </div>
    </section>
    <?php
    }
}
?>

<!-- contact -->
<section class="signup-section" id="signup">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto text-center">
                <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                <h2 class="text-white mb-5">Abonnez-vous!</h2>
                
                <form class="form-inline d-flex">
                    <input class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputPseudo" type="text" placeholder="Entrez votre pseudo" />
                    <input class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputEmail" type="email" placeholder="Entrez votre adresse e-mail..." />
                    <textarea name="contact" id="" cols="30" rows="10"></textarea>
                    <button class="btn btn-primary mx-auto" type="submit">Envoyer</button>
                </form>

            </div>
        </div>
    </div>
</section>