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
        //On ne prend en compte que les appels 2 paramètres dans l'url (le premier étant '/musee')
        if (count($id) === 2 && !empty($id[1])) {
            if (intval($id[1]) > 0) {
                //Récupération des informations du musée passé en paramètre
                $result = $daoMusee->getMuseeById($id[1], true);
            } elseif ($id[1] == 'full') {
                //Récupération de l'ensemble des musées avec les catégories associées
                $result = $daoMusee->getMusees(true);
            }
        } else {
            //Récupération de l'ensemble des musées
            $result = $daoMusee->getMusees(false);
        }
        break;
    case "POST":
        //@todo : Réaliser un controle des données tranmis par le post
        // Ajout d'un nouveau musée
        $musee = new Musee(null, $_POST['nom'], $_POST['description'], null);
        $result = $daoMusee->createMusee($musee);
        break;
    case "PUT":
        // Modification d'un musée
        $id = explode("musee/", $_SERVER['REQUEST_URI']);
        $data = json_decode(file_get_contents("php://input"), false);

        if (isset($data->id) && isset($data->nom) && isset($data->description) && isset($data->categories)){
            $musee = new Musee($data->id, $data->nom, $data->description, $data->categories);
            $result = $daoMusee->modifyMusee($musee);
        }else{
            $result = null;
        }

        break;
    case
    "DELETE":
        // Suppression d'un musée
        $id = explode("musee/", $_SERVER['REQUEST_URI']);
        if (isset($id[1])) {
            $result = $daoMusee->deleteMusee($id[1]);
        }
        break;
}
$dev = false;
if (!is_null($result)) {
    $json = json_encode($result);
    if ($dev) {
        echo '<hr>';
        echo '$RESULT$ = ';
        echo '<hr>';
        echo var_dump($result);
        echo '<hr>';
        echo '<hr>';
        echo '$FORMAT_JSON$ = ';
        echo '<hr>';
        echo $json;
        echo '<hr>';
    } else {
        echo $json;
    }

}

return;