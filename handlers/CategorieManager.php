<?php
/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 28/05/2015
 * Time: 13:42
 */
require_once '../dao/CategorieDao.php';

$daoCategorie = new CategorieDao();
$result = null;

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $id = explode("categorie/", $_SERVER['REQUEST_URI']);
        //Récupération de l'ensemble des catégories
        $result = $daoCategorie->getCategories();

        break;
    case "POST":
        //@todo : Réaliser un controle des données tranmis par le post
        // Ajout d'une nouvelle catégorie
        $data = json_decode(file_get_contents("php://input"), false);
        $categorie = new Categorie(null, $data->label, null);
        $result = $daoCategorie->createCategorie($categorie);
        break;
    case "PUT":
        // Modification d'un musée
        $id = explode("categorie/", $_SERVER['REQUEST_URI']);
        $data = json_decode(file_get_contents("php://input"), false);

        if (isset($data->id) && isset($data->label)) {
            $categorie = new Categorie($data->id, $data->label, $data->categorieParent);
            $result = $daoCategorie->modifyCategorie($categorie);
        } else {
            $result = null;
        }
        break;
    case
    "DELETE":
        // Suppression d'un musée
        $id = explode("categorie/", $_SERVER['REQUEST_URI']);
        if (isset($id[1])) {
            $result = $daoCategorie->deleteCategorie($id[1]);
        }
        break;
}

if (!is_null($result)) {
    $json = json_encode($result);
    echo $json;
}

return;