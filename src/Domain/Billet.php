<?php

namespace writerblog\Domain;

class Billet {

    /**
     * Billet id.
     *
     * @var integer
     */
    private $id;

     /**
     * Billet title.
     *
     * @var string
     */
    private $title;

     /**
     * Billet content.
     *
     * @var string
     */
    private $content;

     /**
     * Date the billet was posted.
     *
     * @var datetime
     */
    private $dateAjout;

    /**
     * Date the billet was updated.
     *
     * @var datetime
     */
    private $dateModif;

    /**
     * Amount of comments associated to a billet.
     *
     * @var integer
     */
    private $nbComments;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getDateAjout() {
        return $this->dateAjout;
    }
    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;
        return $this;
    }

    public function getDateModif() {
        return $this->dateModif;
    }
    public function setDateModif($dateModif) {
        $this->dateModif = $dateModif;
        return $this;
    }

    public function getNbComments() {
        return $this->nbComments;
    }
    public function setNbComments($nbComments) {
        $this->nbComments = $nbComments;
        return $this;
    }
}