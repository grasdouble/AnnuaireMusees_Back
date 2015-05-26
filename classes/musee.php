<?php

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 26/05/2015
 * Time: 21:37
 */
class musee
{

    private $id;
    private $nom;
    private $categories;

    public function __construct()
    {
        $this->id = -1;
    }

    public function __construct1($nom)
    {
        $this->id = -1;
        $this->nom = $nom;
        $this->categories = array();
    }

    public function __construct2($nom, $categories)
    {
        $this->id = -1;
        $this->nom = $nom;
        $this->categories = $categories;
    }

    public function __construct3($id, $nom, $categories)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->categories = $categories;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Complète la liste des catégories
     * @param $categories
     */
    public function addCategories($categories){
        $this->categories = array_merge($this->categories,$categories);
    }
}