<?php


/**
 * Represent a comment in database.
 * Class Comment
 */
class Comment
{
    // Comment ID.
    private $id;
    // Related Article ID.
    private $articleId;
    // Comment text content.
    private $textContent;
    // Comment owner.
    private $user;
    // Created date
    private $createdAt;

    /**
     * Return the Comment ID.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Return the related Article ID.
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }


    /**
     * Set the Comment ID.
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Set the Article ID.
     * @param mixed $articleId
     * @return Comment
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }


    /**
     * Return the comment text content.
     * @return mixed
     */
    public function getTextContent()
    {
        return $this->textContent;
    }


    /**
     * Set the comment text content.
     * @param mixed $textContent
     * @return Comment
     */
    public function setTextContent($textContent)
    {
        $this->textContent = htmlentities($textContent);
        return $this;
    }


    /**
     * Return the ocmment creation date.
     */
    public function getDateCreated()
    {
        return $this->createdAt;
    }


    /**
     * Set the comment creation date
     * @return Comment
     */
    public function setDateCreated($date)
    {
        $this->createdAt = $date;
        return $this;
    }


    /**
     * Return the Comment user owner.
     * @param Mysqli $db
     * @return mixed
     */
    public function getUser(Mysqli $db)
    {
        $req = $db->prepare("SELECT id,username FROM users WHERE id=?");
        $req->bind_param('d', $this->user);
        if($req->execute() && $req->bind_result($id, $username)) {
            // une seule ligne, pas besoin de while.
            $req->fetch();
            $req->close();
            return (new User())->setUsername($username)->setId($id);
        }

        return (new User)->setId($this->user);
    }


    /**
     * Set the Comment user owner.
     * @param mixed $user
     * @return Comment.
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * Save comment in database.
     * @param MySqli $db
     * @return bool
     */
    public function insert(MySqli $db)
    {
        $req = $db->prepare("INSERT INTO commentaires (commentaire, auteur, article) VALUES (?,?,?)");
        $req->bind_param('sdd', $this->textContent, $this->user, $this->articleId);
        $req->execute();
        var_dump($req->error_list);
        $req->close();
    }

}