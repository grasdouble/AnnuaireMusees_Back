<?php
require_once './api/Database.php';

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


    public function requeteSimple()
    {
        $result = $this->db->query("SELECT 1 FROM DUAL");
    }

    public function requeteParametre()
    {
        $query = $this->db->prepare('
          SELECT * FROM musee
          INNER JOIN associationCategMusee ON
            musee.id = associationCategMusee.musee
          WHERE associationCategMusee.categorie = ?');

        $idCateg = 1;

        $query->bind_param('s', $idCateg);
        $query->execute();

        echo 'test';
    }

}

