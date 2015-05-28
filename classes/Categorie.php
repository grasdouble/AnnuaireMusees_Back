<?php

/**
 * Created by PhpStorm.
 * User: sebastien
 * Date: 26/05/2015
 * Time: 22:26
 */
class categorie implements JsonSerializable
{
    private $id;
    private $label;
    private $sousCategories;

    public function __construct($id, $label, $sousCategories)
    {
        $this->id = $id != null ? $id : -1;
        $this->label = $label;
        $this->sousCategories = $sousCategories != null ? $sousCategories : array();
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'sousCategories' => $this->sousCategories
        ];
    }
}