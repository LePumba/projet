<?php
require APP. '/model/DB.php';
require APP . '/model/User.php';

/**
 * Check login post params are set and not empty.
 * @return bool
 */
function checkPostParams() {
    return isset($_POST['username']) && isset($_POST['mail']) &&
           isset($_POST['password']) && isset($_POST['repeatpassword']);
}

?>
<div class="container form-login">
    <h1>Inscription<h1>

            <form method="post" action="index.php?action=register">
                <p>Pseudo</p>
                <input type="text" name="username">
                <p>email</p>
                <input type="email" name="mail">
                <p>Password</p>
                <input type="password" name="password">
                <p>Répetez votre password</p>
                <input type="password" name="repeatpassword"><br><br>
                <input type="submit" name="submit" value="Valider">

            </form>
</div>
<?php
    if (isset($_POST['submit']) && checkPostParams())
    {
        $nom = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['mail']);
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeatpassword'];

        if ($nom && filter_var($email, FILTER_VALIDATE_EMAIL) && $password && $repeatPassword)
        {
            if (strlen($password)>=6)
            {
                if ($password == $repeatPassword)
                {
                    $user = new User();
                    $user->setUsername($nom)->setEmail($email);

                    if(!$user->userExists(DB::getDbLink())) {

                        $user->setPassword($password, true)->setRole("USER");
                        $result = $user->save(DB::getDbLink(), true);
                        $_SESSION['userID'] = $user->getId();
                        $_SESSION['username'] = $user->getUsername();
                        $_SESSION['userRole'] = $user->getRole();

                        if($result)
                            header('Location: ' . APP_HTTP);
                        else
                            echo 'Erreur en ajoutant l\'utilisateur';
                    }
                    else
                        echo "L'utilisateur existe déjà !";
                }
                else
                    echo "Les mots de passe ne sont pas identiques";
            }
            else
                echo "Le mot de passe est trop court !";
        }
        else
            echo "Veuillez saisir tous les champs !";
    }
?>