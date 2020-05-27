<?php


/**
 * Represent an Article in database.
 * Class Article
 */
class Article
{
    // Article ID.
    private $id;
    // Article title.
    private $title;
    // Article content.
    private $content;
    // Article user.
    private $user;
    // Creation date.
    private $createdAt;


    /**
     * Return the Article ID.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set the Article Id.
     * @param mixed $id
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Return the Article title.
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set the Article title.
     * @param mixed $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * Return the Article content.
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * Set the article Content.
     * @param mixed $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    /**
     * Return a portion of the article content.
     * @return false|string
     */
    public function getSummary()
    {
        return substr($this->getContent(), 0, 350);
    }


    /**
     * Return creation date.
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * Set the creation date.
     * @param $date
     * @return Article
     */
    public function setCreatedAt($date)
    {
        $this->createdAt = $date;
        return $this;
    }


    /**
     * Return the Article owner.
     * @param Mysqli $db
     * @return mixed
     */
    public function getUser(MySqli $db)
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
     * Set the Article owner.
     * @param mixed $user
     * @return Article
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * Return the Article comments list
     * @param Mysqli $db
     * @return mixed
     */
    public function fetchComments(Mysqli $db)
    {
        $comments = array();
        $req = $db->prepare("SELECT * FROM commentaires WHERE article=?");

        $req->bind_param('d', $this->id);
        if($req->execute() && $req->bind_result($id, $commentaire, $user, $date, $arid)) {
            // une seule ligne, pas besoin de while.
            while($req->fetch()) {
                $comment = new Comment();
                $comment->setId($id)
                    ->setArticleId($this->getId())
                    ->setUser($user)
                    ->setDateCreated($date)
                    ->setTextContent($commentaire);
                $comments[] = $comment;
            }
        }
        $req->close();

        return $comments;
    }


    /**
     * Load article data based on, its ID.
     * @param $id
     */
    public function loadData(MySqli $db)
    {
        if(!$this->articleExists($db)) {
            return 'Aucun article trouvé avec cet Id';
        }

        $req = $db->prepare("SELECT id, titre, contenu, auteur, date_creation FROM actus WHERE id=?");
        $req->bind_param('s', $this->id);
        if($req->execute() && $req->bind_result($id, $title, $content, $user, $date_created)) {
            $req->fetch();
            $this->setId($id)
                 ->setContent($content)
                 ->setTitle($title)
                 ->setUser($user)
                 ->setCreatedAt($date_created);

            $req->close();
        }
    }


    /**
     * Return true if article exists in the database.
     * @param $db
     * @return boolean
     */
    public function articleExists(MySqli $db) {
        $result = true;
        if(is_null($this->getId()))
            return false;

        $request = $db->prepare("SELECT count(*) as cnt FROM actus WHERE id=?");
        $request->bind_param('d', $this->id);

        if($request->execute() && $request->bind_result($count)) {
            $request->fetch();
            $result = $count > 0;
        }

        $request->close();
        return $result;
    }


    /**
     * Save the Article into the database.
     */
    public function insert(MySqli $db)
    {
        $req = $db->prepare("INSERT INTO actus (titre, contenu, auteur) VALUES (?,?,?)");
        $req->bind_param('ssd', $this->title, $this->content, $this->user);
        $result = $req->execute();
        $req->close();
        return $result;
    }
}
