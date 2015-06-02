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
     * Création d'un musée
     * @param $musee
     * @return int
     * @todo gérer éventuellement une contrainte d'unicité
     */
    public function createMusee($musee)
    {
        $nom = $musee->getNom();
        $description = $musee->getDescription();

        //Ajout du musée en bdd
        $query = $this->db->prepare('
          INSERT INTO musee(nom,description)
          VALUES (?,?)');
        $query->bind_param('ss', $nom, $description);
        $query->execute();
        //Récupération du nouvel id
        $lastId = $query->insert_id;

        //Init de la table associationCategMusee avec le nouveau musée
        $query = $this->db->prepare('
          INSERT INTO associationCategMusee(musee) VALUES (?)');
        $query->bind_param('i', $lastId);
        $query->execute();

        //Fermeture de la connexion
        $query->close();
        return 0;
    }

    /**
     * Modification d'un musée
     * @param $musee
     * @return int
     */
    public function modifyMusee($musee)
    {
        $id = $musee->getId();
        $nom = $musee->getNom();
        $description = $musee->getDescription();
        $categ = $musee->getCategories();

        //Prise en charge des modifications sur le nom ou la description
        $query = $this->db->prepare('
          UPDATE musee set nom=?, description=?
          WHERE id=?');
        $query->bind_param('ssi', $nom, $description, $id);
        $query->execute();

        //Prise en charge des modifications sur la catégorie du musée
        if(intval($categ)){
            $query = $this->db->prepare('
          UPDATE associationCategMusee set categorie=?
          WHERE musee=?');
            $query->bind_param('ii', $categ, $id);
            $query->execute();
        }


        //Fermeture de la connexion
        $query->close();
        return 0;
    }

    /**
     * Suppression d'un musée
     * @param $id
     * @return int
     */
    public function deleteMusee($id)
    {
        //Suppression du musée
        $query = $this->db->prepare('
          DELETE FROM musee where id=?');
        $query->bind_param('i', $id);
        $query->execute();

        //Suppression dans la table d'association Categ/Musee
        $query = $this->db->prepare('
          DELETE FROM associationCategMusee where musee=?');
        $query->bind_param('i', $id);
        $query->execute();

        //Fermeture de la connexion
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

        //Récupération de la liste des musée
        $query = $this->db->query('
          SELECT id, nom, description FROM musee
        ');
        $query->data_seek(0);
        while ($row = $query->fetch_assoc()) {
            $musee = new Musee($row['id'], $row['nom'], $row['description'], null);
            //Si isCategLoad = true, on charge la catégorie du musée
            if ($isCategLoad) {
                $musee->setCategories($categorieDao->getCategorieByIdMusee($row['id']));
            }
            $result[] = $musee;
        }

        //Fermeture de la connexion
        $query->close();
        return $result;
    }

    /**
     * Récupération d'un musée en fonction de son id
     * @param $id
     * @param $isCategLoad
     * @return Musee|null
     */
    public function getMuseeById($id, $isCategLoad)
    {
        $result = null;
        $categorieDao = new CategorieDao();

        //Récupération du musée
        $query = $this->db->prepare('
          SELECT * From musee
          Where musee.id=?');
        $query->bind_param('i', $id);
        $query->execute();
        $query->data_seek(0);
        $data = $query->get_result();

        $row = $data->fetch_assoc();
        $result = new Musee($row['id'], $row['nom'], $row['description'], null);
        if ($isCategLoad) {
            $result->setCategories($categorieDao->getCategorieByIdMusee($row['id']));
        }

        //Fermeture de la connexion
        $query->close();
        return $result;
    }

}