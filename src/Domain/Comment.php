<?php

namespace writerblog\Domain;

use writerblog\Domain\Billet;
use writerblog\Domain\User;

class Comment {

    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment content.
     *
     * @var string
     */
    private $content;
    
    /**
     * Comment author.
     *
     * @var \writerblog\Domain\User
     */
    private $author;

    /**
     * Associated billet.
     *
     * @var \writerblog\Domain\Billet
     */
    private $billet;

    /**
     * Date the comment was posted.
     *
     * @var date
     */
    private $date;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }
    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function getBillet() {
        return $this->billet;
    }
    public function setBillet(Billet $billet) {
        $this->billet = $billet;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
}