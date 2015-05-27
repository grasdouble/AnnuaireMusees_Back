<?php

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 26/05/2015
 * Time: 22:26
 */
class categorie
{
    private $id;
    private $label;
    private $sousCategories;

    public function __construct()
    {
        $this->id = -1;
    }

    public function __construct1($label)
    {
        $this->id = -1;
        $this->label = $label;
        $this->sousCategories = array();
    }

    public function __construct2($label, $sousCategories)
    {
        $this->id = -1;
        $this->label = $label;
        $this->sousCategories = $sousCategories;
    }

    public function __construct3($id, $label, $sousCategories)
    {
        $this->id = $id;
        $this->label = $label;
        $this->sousCategories = $sousCategories;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getSousCategories()
    {
        return $this->sousCategories;
    }

    /**
     * @param mixed $sousCategories
     */
    public function setSousCategories($sousCategories)
    {
        $this->sousCategories = $sousCategories;
    }

    /**
     * Complète la liste des sous catégories
     * @param $sousCategories
     */
    public function addSousCategories($sousCategories)
    {
        $this->sousCategories = array_merge($this->sousCategories, $sousCategories);
    }
}