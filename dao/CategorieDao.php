<?php
require_once '../api/Database.php';
require_once '../classes/Categorie.php';

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

    public function getListCategorieByIdMusee($id)
    {
        $result = array();

        $query = $this->db->prepare('
          SELECT * From categorie
          INNER JOIN associationCategMusee ON
            categorie.id = associationCategMusee.categorie
          INNER JOIN musee ON
            associationCategMusee.musee = musee.id
          Where musee.id=?');

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
}