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
    private $categorieParent;

    public function __construct($id, $label, $categorieParent)
    {
        $this->id = $id != null ? $id : -1;
        $this->label = $label;
        $this->categorieParent = $categorieParent;
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
    public function getCategorieParent()
    {
        return $this->categorieParent;
    }

    /**
     * @param mixed $categorieParent
     */
    public function setCategorieParent($categorieParent)
    {
        $this->categorieParent = $categorieParent;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'categorieParent' => $this->categorieParent
        ];
    }
}