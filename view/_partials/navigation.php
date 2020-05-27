<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container" style="background: rgba(27,30,33,0.76)">
        <a class="navbar-brand js-scroll-trigger" href="<?= APP_HTTP ?>"><img src="<?= APP_HTTP ?>/assets/img/Fond-blanc-texte.png" style="height: 5rem; width: 5rem"></a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/#about">Á Propos</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/#projects">Actualités</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/#signup">Contact</a></li>
                <?php
                if(isset($_SESSION['userRole']) && isset($_SESSION['userID']) && $_SESSION['userRole'] === 'ADMIN') { ?>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/?action=article-add">
                            Ajouter article
                        </a>
                    </li><?php
                }
                ?>
                <li class="nav-item">
                    <?php
                    if(isset($_SESSION['userID']) && isset($_SESSION['username'])) {?>
                    <a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/?action=logout">
                        <?= $_SESSION['username'] ?>
                        </a><?php
                    }
                    else {?>
                    <a class="nav-link js-scroll-trigger" href="<?= APP_HTTP ?>/?action=login">
                            Se connecter
                        </a><?php
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>