<?php


/**
 * Represent a User in database.
 * Class User
 */
class User
{
    // The user ID.
    private $id;
    // The user username.
    private $username;
    // The user email.
    private $email;
    // The user password.
    private $password;
    // The user joindate.
    private $dateJoin;
    // The user avatar.
    private $avatar;
    // The user role
    private $role;


    /**
     * Return the User ID.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set the User ID.
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Return the username.
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Set the User username.
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    /**
     * Return the User email.
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set the USer email.
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    /**
     * Return the user encoded password.
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set the User password
     * @param mixed $password
     * @param bool $encode
     * @return User
     */
    public function setPassword($password, $encode = false)
    {
        $this->password = $encode ? password_hash($password, PASSWORD_BCRYPT) : $password;
        return $this;
    }


    /**
     * Return the User join date.
     * @return mixed
     */
    public function getDateJoin()
    {
        return $this->dateJoin;
    }


    /**
     * Set the User join date.
     * @param mixed $dateJoin
     * @return User
     */
    public function setDateJoin($dateJoin)
    {
        $this->dateJoin = $dateJoin;
        return $this;
    }


    /**
     * Return the User avatar.
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }


    /**
     * Set the User avatar.
     * @param mixed $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }


    /**
     * Return the user role.
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set the user role.
     * @param $role
     * @return User
     */
    public function setRole($role)
    {
        // Ensure role is ADMIN or USER, USER is the default role in case bad role provided.
        if(in_array($role, ["ADMIN", "USER"]))
            $this->role = $role;
        else
            $this->role = "USER";

        return $this;
    }


    /**
     * Return true if user exists in the database.
     * @param $db
     * @return boolean
     */
    public function userExists(MySqli $db) {
        $result = true;
        // Pas d'enregistrement possible si aucune donnée fournie.
        if(is_null($this->getUsername()) || is_null($this->getEmail()))
            return true;

        $request = $db->prepare("SELECT id FROM users WHERE username=?");
        $request->bind_param('ss', $this->username, $this->email);
        $userId = null;

        if($request->execute() && $request->bind_result($userId)) {
            // Je prend la première ligne retournée car un seul utilisateur avec un seul username / email peut exister dans la bdd.
            $request->fetch();
            $result = null !== $userId;
        }

        $request->close();
        // Return true to make sure no insert can be done if an sql error occurred.
        return $result;
    }


    /**
     * Check if password is valid.
     * @param $plainTextPassword
     * @return boolean
     */
    public function isValidPassword($plainTextPassword)
    {
        return password_verify($plainTextPassword, $this->getPassword());
    }


    /**
     * Save the current user in database.
     * @param $db
     * @param bool $insertMode
     * @return boolean
     */
    public function save(MySqli $db, $insertMode=false)
    {
        if($insertMode) {
            $dateAdd = date( 'Y-m-d H:i:s');
            $req = $db->prepare("INSERT INTO users (username, mail, password, role, date_inscription) VALUES (?,?,?,?,?)");
            $req->bind_param('sssss', $this->username, $this->email, $this->password,  $this->role, $dateAdd);
        }
        else {
            $req = $db->prepare("UPDATE users set username=?, mail=?, password=?, role=? WHERE id=?");
            $req->bind_param('ssssd', $this->username, $this->email, $this->password, $this->role, $this->id);
        }

        $result = $req->execute();
        if($insertMode)
            $this->setId($req->insert_id);
        $req->close();
        return $result;
    }


    public function loadData(Mysqli $db)
    {
        if(is_null($this->getUsername()))
            return false;

        $req = $db->prepare("SELECT id, username, mail, password, date_inscription, role FROM users WHERE username=?");
        $req->bind_param('s', $this->username);
        if($req->execute() && $req->bind_result($id, $username, $mail, $password, $date_inscription, $role)) {
            $req->fetch();
            $this->setId($id)
                 ->setUsername($username)
                 ->setPassword($password)
                 ->setDateJoin($date_inscription)
                 ->setEmail($mail)
                 ->setRole($role);

            $req->close();
        }
    }
}