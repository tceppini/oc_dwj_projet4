<?php

namespace writerblog\DAO;

use writerblog\Domain\Billet;

class BilletDAO extends DAO {

    /**
     * Creates a billet into the database.
     *
     * @param \writerblog\Domain\Billet $billet The billet to create
     */
    public function create(Billet $billet) {
        $billetArray = array(
            'billet_title' => $billet->getTitle(),
            'billet_content' => $billet->getContent(),
            'billet_dateAjout' => $billet->getDateAjout(),
            'billet_nbComments' => $billet->getNbComments()
        );
        $this->getDb()->insert('P4_t_billet', $billetArray);
        $id = $this->getDb()->lastInsertId();
        $billet->setId($id);
    }

    /**
     * Return a list of all billets, sorted by id (most recent first).
     *
     * @return array a list of all billets.
     */
    public function readAll() {
        $sql = 'select * from P4_t_billet order by billet_id desc';
        $result = $this->getDb()->fetchAll($sql);
        $billets = array();
        foreach ($result as $row) {
            $idBillet = $row['billet_id'];
            $billets[$idBillet] = $this->buildDomainObject($row);
        }
        return $billets;
    }

    /**
     * Returns a billet matching the supplied id.
     *
     * @param integer $id The billet id
     *
     * @return \writerblog\Domain\Billet|throws an exception if no matching billet is found
     */
    public function read($id) {
        $sql = 'select * from P4_t_billet where billet_id = ?';
        $result = $this->getDb()->fetchAssoc($sql, array($id));
        if ($result) {
            return $this->buildDomainObject($result);
        } else {
            throw new \Exception ("No billet matching id " . $id);
        }
    }

    /**
     * Updates a billet.
     *
     * @param \writerblog\Domain\Billet $billet The billet to update
     */
    public function update(Billet $billet) {
        $billetArray = array(
            'billet_title' => $billet->getTitle(),
            'billet_content' => $billet->getContent(),
            'billet_dateAjout' => $billet->getDateAjout(),
            'billet_dateModif' => $billet->getDateModif(),
            'billet_nbComments' => $billet->getNbComments()
        );
        $this->getDb()->update('P4_t_billet', $billetArray, array('billet_id' => $billet->getId()));
    }
    
    /**
     * Removes a billet from the database.
     *
     * @param integer $id The billet id.
     */
    public function deleteBillet($id) {
        $this->getDb()->delete('P4_t_billet', array('billet_id' => $id));
    }
    
    /**
     * Creates a billet object based on a DB row.
     *
     * @param array $row The DB row containing billet data.
     * @return \writerblog\Domain\Billet
     */
    public function buildDomainObject($row) {
        $billet = new Billet();
        $billet->setId($row['billet_id']);
        $billet->setTitle($row['billet_title']);
        $billet->setContent($row['billet_content']);
        $billet->setDateAjout($row['billet_dateAjout']);
        $billet->setDateModif($row['billet_dateModif']);
        $billet->setNbComments($row['billet_nbComments']);
        return $billet;
    }

    /**
     * Count the amount of comments from a billet.
     *
     * @param integer $idBillet The billet id.
     * @return integer The amount of comments
     */
    public function countComments($idBillet) {
        $sql = 'select * from P4_t_comment where billet_id = ?';
        return $this->getDb()->executeQuery($sql, array($idBillet))->rowCount();
    }   
}