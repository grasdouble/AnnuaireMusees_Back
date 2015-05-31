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

    /**
     * Récupération de la liste des categories lite
     * @return array
     */
    public function getCategoriesLite()
    {
        $result = array();
        $query = $this->db->query('
          SELECT id, label FROM categorie
        ');
        $query->data_seek(0);

        while ($row = $query->fetch_assoc()) {
            $categorie =[
                'id' => $row['id'],
                'label' => $row['label']
            ];

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
          INNER JOIN associationCateg ON categorie.id = associationCateg.categ
          WHERE categorie.id = ?');

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
        $query = $this->db->prepare('
          UPDATE categorie set label=?
          WHERE id=?');

        $id = $categorie->getId();
        $label = $categorie->getLabel();

        $query->bind_param('si', $label, $id);
        $query->execute();
        $query->close();
        return 0;
    }

    public function deleteMusee($id)
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
}