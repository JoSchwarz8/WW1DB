<?php

require_once 'DBconnect.php';  // Database connection
require_once 'function.php';     // Function file
class Edit {
    private $surname;
    private $forename;
    private $regiment;
    private $unit;
    private $memorial;
    private $memorial_location;
    private $memorial_info;
    private $memorial_postcode;
    private $district;
    private $photo_available;

    public function __construct() {
        // Constructor vacío, sin excepciones SQL en PHP
    }

    // Getters y Setters
    public function getSurname() {
        return $this->surname;
    }
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getForename() {
        return $this->forename;
    }
    public function setForename($forename) {
        $this->forename = $forename;
    }

    public function getRegiment() {
        return $this->regiment;
    }
    public function setRegiment($regiment) {
        $this->regiment = $regiment;
    }

    public function getUnit() {
        return $this->unit;
    }
    public function setUnit($unit) {
        $this->unit = $unit;
    }

    public function getMemorial() {
        return $this->memorial;
    }
    public function setMemorial($memorial) {
        $this->memorial = $memorial;
    }

    public function getMemorial_location() {
        return $this->memorial_location;
    }
    public function setMemorial_location($memorial_location) {
        $this->memorial_location = $memorial_location;
    }

    public function getMemorial_info() {
        return $this->memorial_info;
    }
    public function setMemorial_info($memorial_info) {
        $this->memorial_info = $memorial_info;
    }

    public function getMemorial_postcode() {
        return $this->memorial_postcode;
    }
    public function setMemorial_postcode($memorial_postcode) {
        $this->memorial_postcode = $memorial_postcode;
    }

    public function getDistrict() {
        return $this->district;
    }
    public function setDistrict($district) {
        $this->district = $district;
    }

    public function getPhoto_available() {
        return $this->photo_available;
    }
    public function setPhoto_available($photo_available) {
        $this->photo_available = $photo_available;
    }

    // Crea una nueva instancia copiando los valores actuales
    public function getEdit() {
        $edit = new Edit();
        $edit->setSurname($this->surname);
        $edit->setForename($this->forename);
        $edit->setRegiment($this->regiment);
        $edit->setUnit($this->unit);
        $edit->setMemorial($this->memorial);
        $edit->setMemorial_info($this->memorial_info);
        $edit->setMemorial_location($this->memorial_location);
        $edit->setDistrict($this->district);
        $edit->setMemorial_postcode($this->memorial_postcode);
        $edit->setPhoto_available($this->photo_available);
        return $edit;
    }

    // Método para guardar el objeto a través del DAO (se asume que existe la clase EditDAO)
    public function save() {
        $editDAO = new EditDAO();
        return $editDAO->edit($this);
    }
}
