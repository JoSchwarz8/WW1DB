<?php
class EditBurials {
    private $surname;
    private $forename;
    private $dob;
    private $medals;
    private $date_of_death;
    private $rank;
    private $service_number;
    private $regiment;
    private $battalion;
    private $cemetery;
    private $grave_reference;
    private $info;
    private $original_service_number;

    public function __construct() {
        // Empty constructor
        error_log("EditBurials instance created");
    }

    // Getters and Setters
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

    public function getDoB() {
        return $this->dob;
    }
    public function setDoB($dob) {
        $this->dob = $dob;
    }

    public function getMedals() {
        return $this->medals;
    }
    public function setMedals($medals) {
        $this->medals = $medals;
    }

    public function getDate_of_Death() {
        return $this->date_of_death;
    }
    public function setDate_of_Death($date_of_death) {
        $this->date_of_death = $date_of_death;
    }

    public function getRank() {
        return $this->rank;
    }
    public function setRank($rank) {
        $this->rank = $rank;
    }

    public function getService_Number() {
        return $this->service_number;
    }
    public function setService_Number($service_number) {
        $this->service_number = $service_number;
    }

    public function getRegiment() {
        return $this->regiment;
    }
    public function setRegiment($regiment) {
        $this->regiment = $regiment;
    }

    public function getBattalion() {
        return $this->battalion;
    }
    public function setBattalion($battalion) {
        $this->battalion = $battalion;
    }

    public function getCemetery() {
        return $this->cemetery;
    }
    public function setCemetery($cemetery) {
        $this->cemetery = $cemetery;
    }

    public function getGrave_Reference() {
        return $this->grave_reference;
    }
    public function setGrave_Reference($grave_reference) {
        $this->grave_reference = $grave_reference;
    }

    public function getInfo() {
        return $this->info;
    }
    public function setInfo($info) {
        $this->info = $info;
    }

    public function getOriginal_Service_Number() {
        return $this->original_service_number;
    }
    public function setOriginal_Service_Number($original_service_number) {
        $this->original_service_number = $original_service_number;
        error_log("Original service number set to: " . $original_service_number);
    }

    // Debug function to output all properties
    public function debugOutput() {
        $data = [
            'surname' => $this->surname,
            'forename' => $this->forename,
            'dob' => $this->dob,
            'medals' => $this->medals,
            'date_of_death' => $this->date_of_death,
            'rank' => $this->rank,
            'service_number' => $this->service_number,
            'regiment' => $this->regiment,
            'battalion' => $this->battalion,
            'cemetery' => $this->cemetery,
            'grave_reference' => $this->grave_reference,
            'info' => $this->info,
            'original_service_number' => $this->original_service_number
        ];
        error_log("EditBurials data: " . json_encode($data));
        return $data;
    }

    // Method to save the object via DAO
    public function save($dao = null) {
        if ($dao === null) {
            error_log("Creating new EditDAO instance in EditBurials save method");
            $dao = new EditDAO();
        } else {
            error_log("Using provided EditDAO instance in EditBurials save method");
        }
        
        // Log all data before saving
        error_log("EditBurials save: About to save with data: " . json_encode($this->debugOutput()));
        
        $result = $dao->editBurials($this);
        error_log("EditBurials save result: " . ($result ? "success" : "failure"));
        return $result;
    }
} 