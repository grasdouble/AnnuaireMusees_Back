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

    public function createMusee($musee)
    {
        $query = $this->db->prepare('
          INSERT INTO musee(nom,description)
          VALUES (?,?)');

        $query->bind_param('s', $musee->nom, $musee->description);
        $query->execute();
        return 0;
    }

    public function modifyMusee($musee)
    {
        $query = $this->db->prepare('
          UPDATE musee set nom=?, description=?
          WHERE id=?');

        $query->bind_param('ssi', $musee->nom, $musee->description, $musee->id);
        $query->execute();
        return 0;
    }

    public function deleteMusee($id)
    {
        $query = $this->db->prepare('
          DELETE FROM musee where id=?');

        $query->bind_param('i', $id);
        $query->execute();
        return 0;
    }

    //Récupération de la liste des musées
    public function getMusees()
    {
        $result = array();

        $query = $this->db->query('
          SELECT id, nom, description FROM musee
        ');
        $query->data_seek(0);

        while ($row = $query->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            $result[] = $musee;
        }
        $query->close();
        return $result;
    }

    //Récupération de la liste des musées avec leurs catégories
    public function getMuseesWithCateg()
    {
        $result = array();

        $query = $this->db->query('
          SELECT id, nom, description FROM musee
        ');
        $query->data_seek(0);

        $categorieDao = new CategorieDao();
        while ($row = $query->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            $musee->setCategories($categorieDao->getListCategorieByIdMusee($row['id']));
            $result[] = $musee;
        }
        $query->close();
        return $result;
    }

    public function getMuseeById($id)
    {
        $query = $this->db->prepare('
          SELECT * From musee
          INNER JOIN associationCategMusee ON
            musee.id = associationCategMusee.musee
          INNER JOIN categorie ON
            associationCategMusee.categorie = categorie.id
          Where musee.id=?');

        $query->bind_param('i', $id);
        $query->execute();
    }

    public function getListMuseeByCateg()
    {

    }

}