<?php
require_once '../api/Database.php';
require_once '../classes/Categorie.php';
require_once '../dao/CategorieDao.php';

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 28/05/2015
 * Time: 01:08
 */
class CategorieDao
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupération de la liste des categories
     * @return array
     */
    public function getCategories()
    {
        $result = array();

        $query = $this->db->query('
          SELECT id, label FROM categorie
        ');
        $query->data_seek(0);

        while ($row = $query->fetch_assoc()) {
            $categorie = new Categorie($row['id'], $row['label'], null);
            $categorieParent = $this->getCategorieParent($row['id']);
            if (isset($categorieParent)) {
                $categorie->setCategorieParent($categorieParent->getLabel());
            }
            $result[] = $categorie;
        }
        $query->close();
        return $result;
    }

    public function getCategorieParent($id)
    {
        $result = null;

        $query = $this->db->prepare('
          SELECT categorie.id, categorie.label
          FROM categorie
          INNER JOIN associationCateg ON categorie.id = associationCateg.categParent
          WHERE associationCateg.categ = ?');

        $query->bind_param('i', $id);
        $query->execute();

        $query->data_seek(0);
        $data = $query->get_result();

        while ($row = $data->fetch_assoc()) {
            $categorie = new Categorie($row['id'], $row['label'], null);

            $result = $categorie;
        }
        $query->close();
        return $result;
    }

    public function getCategorieByIdMusee($id)
    {
        $result = array();

        $query = $this->db->prepare('
          SELECT * From categorie
          INNER JOIN associationCategMusee ON
            categorie.id = associationCategMusee.categorie
          INNER JOIN musee ON
            associationCategMusee.musee = musee.id
          WHERE musee.id=?');

        $query->bind_param('i', $id);
        $query->execute();

        $query->data_seek(0);
        $data = $query->get_result();

        while ($row = $data->fetch_assoc()) {
            $categorie = new Categorie($row['id'], $row['label'], null);
            $result[] = $categorie;
        }
        $query->close();
        return $result;
    }

    public function modifyCategorie($categorie)
    {
        $id = $categorie->getId();
        $label = $categorie->getLabel();
        $categParent = $categorie->getCategorieParent();

        $query = $this->db->prepare('
          UPDATE categorie set label=?
          WHERE id=?');

        $query->bind_param('si', $label, $id);
        $query->execute();

        $query = $this->db->prepare('
          UPDATE associationCateg set categParent=?
          WHERE categ=?');

        $query->bind_param('ii', $categParent, $id);
        $query->execute();

        $query->close();
        return $categorie;
    }

    public function deleteCategorie($id)
    {
        //@todo : vérifier la présence de catégorie fille
        $query = $this->db->prepare('
          DELETE FROM categorie where id=?');

        $query->bind_param('i', $id);
        $query->execute();

        $query = $this->db->prepare('
          DELETE FROM associationCateg where categ=? or categParent=?');

        $query->bind_param('ii', $id, $id);
        $query->execute();

        $query = $this->db->prepare('
          DELETE FROM associationCategMusee where categorie=?');

        $query->bind_param('i', $id);
        $query->execute();
        $query->close();

        return 0;
    }

    /**
     * @param $musee
     * @return int
     * @todo gérer éventuellement une contrainte d'unicité
     */
    public function createCategorie($categorie)
    {
        $label = $categorie->getLabel();

        $query = $this->db->prepare('
          INSERT INTO categorie(label)
          VALUES (?)');
        $query->bind_param('s', $label);
        $query->execute();
        $lastId = $query->insert_id;

        $query = $this->db->prepare('
          INSERT INTO associationCateg(categ) VALUES (?)');
        $query->bind_param('i', $lastId);
        $query->execute();

        $query->close();
        return $lastId;
    }
}