<?php
/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 27/05/2015
 * Time: 23:14
 */
require_once "../dao/MuseeDao.php";
require_once '../dao/CategorieDao.php';

$daoMusee = new MuseeDao();
$result = null;

switch ($_SERVER['REQUEST_METHOD']) {

    case "GET":
        $id = explode("musee/", $_SERVER['REQUEST_URI']);
        var_dump($id);
        //On ne prend en compte que les appels 2 paramètres dans l'url (le premier étant '/musee')
        if (count($id) === 2) {
            if (is_numeric($id[1])) {
                //Récupération des informations du musée passé en paramètre
                $result = $daoMusee->getMuseeById($id[1]);
            } elseif ($id[1] == 'full') {
                //Récupération de l'ensemble des musées avec les catégories associées
                $result = $daoMusee->getMuseesWithCateg();
            }
        } else {
            //Récupération de l'ensemble des musées
            $result = $daoMusee->getMusees();
        }
        break;
    case "POST":
        // Ajout d'un nouveau musée
        $result = $daoMusee->createMusee($_POST);
        break;
    case "PUT":
        // Modification d'un musée
        $d = json_decode(file_get_contents("php://input"), false);
        $result = $daoMusee->modifyMusee($d);
        break;
    case "DELETE":
        // Suppression d'un musée
        $id = explode("musee/", $_SERVER['REQUEST_URI']);
        if (isset($id[1])) {
            $result = $daoMusee->deleteMusee($id[1]);
        }
        break;
}
if (!is_null($result)) {
    $json = json_encode($result);
    echo var_dump($result);
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo $json;
}

return;