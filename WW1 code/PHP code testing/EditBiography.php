<?php
class EditBiography {
    private $surname;
    private $forename;
    private $regiment;
    private $service_Number;
    private $biography_attachment;

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

    public function getService_Number() {
        return $this->service_Number;
    }
    public function setService_Number($service_Number) {
        $this->service_Number = $service_Number;
    }

    public function getBiography_attachment() {
        return $this->biography_attachment;
    }
    public function setBiography_attachment($biography_attachment) {
        $this->biography_attachment = $biography_attachment;
    }

    // Debug function to output all properties
    public function debugOutput() {
        return [
            'surname' => $this->surname,
            'forename' => $this->forename,
            'regiment' => $this->regiment,
            'service_Number' => $this->service_Number,
            'biography_attachment' => $this->biography_attachment
        ];
    }

    // Método para guardar el objeto a través del DAO (se asume que existe la clase EditDAO)
    public function save() {
        $editDAO = new EditDAO();
        return $editDAO->editBiography($this);
    }
}
