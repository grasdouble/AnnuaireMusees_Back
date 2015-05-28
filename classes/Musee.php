<?php

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 26/05/2015
 * Time: 21:37
 */
class Musee implements JsonSerializable
{

    private $id;
    private $nom;
    private $description;
    private $categories;

    public function __construct($id, $nom, $description, $categories)
    {
        $this->id = $id != null ? $id : -1;
        $this->nom = $nom;
        $this->description = $description;
        $this->categories = $categories != null ? $categories : array();
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function addCategories($categories)
    {
        $this->categories = array_merge($this->categories, $categories);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'categories' => $this->categories
        ];
    }
}