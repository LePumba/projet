<?php
require 'model/DB.php';
require 'model/User.php';

?>
<div class="container form-login">
    <h1>Connexion utilisateur<h1><br>

            <form method="post" action="index.php?action=login">
                <p>Pseudo</p>
                <input type="text" name="username">
                <p>Password</p>
                <input type="password" name="password">
                <br>
                <input type="submit" name="submit" value="Valider">
                <br>
                <a href="<?= APP_HTTP ?>/?action=register">S'enregistrer</a>
            </form>
</div>
<?php
    if(isset($_SESSION['userID'])) {
        header('Location: ' . APP_HTTP);
        die();
    }

    if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password))
        {
            $user = new User();
            $user->setUsername($username);

            if($user->userExists(DB::getDbLink()))
            {
                $user->loadData(DB::getDbLink());

                if($user->isValidPassword($password)) {
                    $_SESSION['userID'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['userRole'] = $user->getRole();
                    header('Location: ' . APP_HTTP);
                }
                else {
                    echo 'Le mot de pâsse n\'est pas correct !';
                }
            }
            else
                echo "Désolé, cet utilisateur n'a pu être trouvé !";
        }
        else
            echo "Veuillez saisir tous les champs !";
    }
?>
