<?php

namespace writerblog\DAO;

use writerblog\Domain\Comment;
use writerblog\DAO\BilletDAO;
use writerblog\DAO\UserDAO;

class CommentDAO extends DAO {

    /**
     * @var \writerblog\DAO\BilletDAO
     */
    private $billetDAO;

    /**
     * @var \writerblog\DAO\UserDAO
     */
    private $userDAO;
    
    public function setBilletDAO(BilletDAO $billetDAO) {
        $this->billetDAO = $billetDAO;
        return $this;
    }
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
        return $this;
    }

    /**
     * Return a list of all comments for a billet, sorted by id (most recent first).
     *
     * @param integer $idBillet The billet id.
     *
     * @return array A list of all comments for the billet.
     */
    public function readAllByIdBillet($idBillet) {
        $sql = "select * from P4_t_comment where billet_id = ? order by com_id desc";
        $result = $this->getDb()->fetchAll($sql, array($idBillet));
        $dataComment = array();
        foreach ($result as $row) {
            $commentId = $row['com_id'];
            $dataComment[$commentId] = $this->buildDomainObject($row);
        }
        return $dataComment;
    }

    /**
     * Returns a list of all comments, sorted by id (most recent first).
     *
     * @return array A list of all comments.
     */
    public function readAll() {
        $sql = "select * from P4_t_comment order by billet_id desc";
        $result = $this->getDb()->fetchAll($sql);
        $dataComment = array();
        foreach ($result as $row) {
            $commentId = $row['com_id'];
            $dataComment[$commentId] = $this->buildDomainObject($row);
        }
        return $dataComment;
    }

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \writerblog\Domain\Comment|throws an exception if no matching comment is found
     */
    public function read($id) {
        $sql = "select * from P4_t_comment where com_id = ?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No comment matching id : " . $id);
        }
    }

    /**
     * Creates a Comment object based on a DB row.
     *
     * @param array $row The DB row containing comment data.
     * @return \writerblog\Domain\Comment
     */
    public function buildDomainObject($row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setDate($row['com_date']);
        if (array_key_exists('billet_id', $row)) {
            $idBillet = $row['billet_id'];
            $billet = $this->billetDAO->read($idBillet);
            $comment->setBillet($billet);
        }
        if (array_key_exists('user_id', $row)) {
            $userId = $row['user_id'];
            $author = $this->userDAO->read($userId);
            $comment->setAuthor($author);
        }
        return $comment;
    }

    /**
     * Saves a comment into the database.
     *
     * @param \writerblog\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $dataComment = array(
            'com_content' => $comment->getContent(),
            'com_date' => $comment->getDate(),
            'billet_id' => $comment->getBillet()->getId(),
            'user_id' => $comment->getAuthor()->getId()
        );
        if ($comment->getId()) {
            $this->getDb()->update('P4_t_comment', $dataComment, array('com_id' => $comment->getId()));
        } else {
            $this->getDb()->insert('P4_t_comment', $dataComment);
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }

    /**
     * Removes all comments for a billet
     *
     * @param $id The id of the billet
     */
    public function deleteAllByIdBillet($id) {
        $this->getDb()->delete('P4_t_comment', array('billet_id' => $id));
    }

     /**
     * Removes all comments for a user
     *
     * @param integer $id The id of the user
     */
    public function deleteAllByIdUser($id) {
        $this->getDb()->delete('P4_t_comment', array('user_id' => $id));        
    }

    /**
     * Removes a comment from the database.
     *
     * @param integer $id The comment id
     */
    public function delete($id) {
        $this->getDb()->delete('P4_t_comment', array('com_id' => $id));        
    }
}
