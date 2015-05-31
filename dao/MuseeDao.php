<?php
require_once '../api/Database.php';
require_once '../classes/Musee.php';
require_once '../dao/CategorieDao.php';

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 27/05/2015
 * Time: 02:25
 */
class MuseeDao
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param $musee
     * @return int
     * @todo gérer éventuellement une contrainte d'unicité
     */
    public function createMusee($musee)
    {
        $query = $this->db->prepare('
          INSERT INTO musee(nom,description)
          VALUES (?,?)');

        $nom = $musee->getNom();
        $description = $musee->getDescription();
        $query->bind_param('ss', $nom, $description);
        $query->execute();
        $query->close();
        return 0;
    }

    public function modifyMusee($musee)
    {
        $id = $musee->getId();
        $nom = $musee->getNom();
        $description = $musee->getDescription();
        $categ = $musee->getCategories();

        $query = $this->db->prepare('
          UPDATE musee set nom=?, description=?
          WHERE id=?');

        $query->bind_param('ssi', $nom, $description, $id);
        $query->execute();

        $query = $this->db->prepare('
          UPDATE associationCategMusee set categorie=?
          WHERE musee=?');

        $query->bind_param('ii', $categ, $id);
        $query->execute();

        $query->close();
        return 0;
    }

    public function deleteMusee($id)
    {
        $query = $this->db->prepare('
          DELETE FROM musee where id=?');

        $query->bind_param('i', $id);
        $query->execute();

        $query = $this->db->prepare('
          DELETE FROM associationCategMusee where musee=?');

        $query->bind_param('i', $id);
        $query->execute();
        $query->close();
        return 0;
    }

    /**
     * Récupération de la liste des musées
     * @Param $isCategLoad : boolean
     * @return array
     */
    public function getMusees($isCategLoad)
    {
        $result = array();
        $categorieDao = new CategorieDao();

        $query = $this->db->query('
          SELECT id, nom, description FROM musee
        ');
        $query->data_seek(0);

        while ($row = $query->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            if ($isCategLoad) {
                $musee->setCategories($categorieDao->getCategorieByIdMusee($row['id']));
            }
            $result[] = $musee;
        }
        $query->close();
        return $result;
    }

    /**
     * Récupération d'un musée en fonction de son id
     * @param $id : int
     * @param $isCategLoad : boolean
     * @return array
     */
    public function getMuseeById($id, $isCategLoad)
    {
        $result = array();
        $categorieDao = new CategorieDao();

        $query = $this->db->prepare('
          SELECT * From musee
          Where musee.id=?');
        $query->bind_param('i', $id);
        $query->execute();

        $query->data_seek(0);
        $data = $query->get_result();

        while ($row = $data->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            if ($isCategLoad) {
                $musee->setCategories($categorieDao->getCategorieByIdMusee($row['id']));
            }
            $result[] = $musee;
        }
        $query->close();
        return $result;
    }

    /**
     * Récupère la liste des musées en fonction d'une catégorie
     * @param $id
     * @param $isCategLoad
     * @return array
     */
    public function getListMuseeByCateg($id, $isCategLoad)
    {
        $result = array();
        $categorieDao = new CategorieDao();

        $query = $this->db->prepare('
          SELECT * From musee
          INNER JOIN associationCategMusee ON
            musee.id = associationCategMusee.musee
          INNER JOIN categorie ON
            associationCategMusee.categorie = categorie.id
          Where categorie.id=?');
        $query->bind_param('i', $id);
        $query->execute();

        $query->data_seek(0);
        $data = $query->get_result();

        while ($row = $data->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            if ($isCategLoad) {
                $musee->setCategories($categorieDao->getListCategorieByIdMusee($row['id']));
            }
            $result[] = $musee;
        }
        $query->close();

        return $result;
    }

}