<?php
class EditGwroh {
    private $surname;
    private $forename;
    private $address;
    private $electoral_ward;
    private $town;
    private $rank;
    private $regiment;
    private $battalion;
    private $company;
    private $dob;
    private $service_no;
    private $other_regiment;
    private $other_unit;
    private $other_service_no;
    private $medals;
    private $enlistment_date;
    private $discharge_date;
    private $date; // Death (in service) date
    private $misc_info_nroh;
    private $misc_info_cwgc;
    private $cemetery_memorial;
    private $cemetery_memorial_ref;
    private $cemetery_memorial_country;
    private $original_service_no;

    public function __construct() {
        // Empty constructor
        error_log("EditGwroh instance created");
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

    public function getAddress() {
        return $this->address;
    }
    public function setAddress($address) {
        $this->address = $address;
    }

    public function getElectoral_Ward() {
        return $this->electoral_ward;
    }
    public function setElectoral_Ward($electoral_ward) {
        $this->electoral_ward = $electoral_ward;
    }

    public function getTown() {
        return $this->town;
    }
    public function setTown($town) {
        $this->town = $town;
    }

    public function getRank() {
        return $this->rank;
    }
    public function setRank($rank) {
        $this->rank = $rank;
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

    public function getCompany() {
        return $this->company;
    }
    public function setCompany($company) {
        $this->company = $company;
    }

    public function getDoB() {
        return $this->dob;
    }
    public function setDoB($dob) {
        $this->dob = $dob;
    }

    public function getService_no() {
        return $this->service_no;
    }
    public function setService_no($service_no) {
        $this->service_no = $service_no;
    }

    public function getOther_Regiment() {
        return $this->other_regiment;
    }
    public function setOther_Regiment($other_regiment) {
        $this->other_regiment = $other_regiment;
    }

    public function getOther_Unit() {
        return $this->other_unit;
    }
    public function setOther_Unit($other_unit) {
        $this->other_unit = $other_unit;
    }

    public function getOther_Service_no() {
        return $this->other_service_no;
    }
    public function setOther_Service_no($other_service_no) {
        $this->other_service_no = $other_service_no;
    }

    public function getMedals() {
        return $this->medals;
    }
    public function setMedals($medals) {
        $this->medals = $medals;
    }

    public function getEnlistment_Date() {
        return $this->enlistment_date;
    }
    public function setEnlistment_Date($enlistment_date) {
        $this->enlistment_date = $enlistment_date;
    }

    public function getDischarge_Date() {
        return $this->discharge_date;
    }
    public function setDischarge_Date($discharge_date) {
        $this->discharge_date = $discharge_date;
    }

    public function getDate() {
        return $this->date;
    }
    public function setDate($date) {
        $this->date = $date;
    }

    public function getMisc_info_Nroh() {
        return $this->misc_info_nroh;
    }
    public function setMisc_info_Nroh($misc_info_nroh) {
        $this->misc_info_nroh = $misc_info_nroh;
    }

    public function getMisc_info_cwgc() {
        return $this->misc_info_cwgc;
    }
    public function setMisc_info_cwgc($misc_info_cwgc) {
        $this->misc_info_cwgc = $misc_info_cwgc;
    }

    public function getCemetery_Memorial() {
        return $this->cemetery_memorial;
    }
    public function setCemetery_Memorial($cemetery_memorial) {
        $this->cemetery_memorial = $cemetery_memorial;
    }

    public function getCemetery_Memorial_Ref() {
        return $this->cemetery_memorial_ref;
    }
    public function setCemetery_Memorial_Ref($cemetery_memorial_ref) {
        $this->cemetery_memorial_ref = $cemetery_memorial_ref;
    }

    public function getCemetery_Memorial_Country() {
        return $this->cemetery_memorial_country;
    }
    public function setCemetery_Memorial_Country($cemetery_memorial_country) {
        $this->cemetery_memorial_country = $cemetery_memorial_country;
    }

    public function getOriginal_Service_no() {
        return $this->original_service_no;
    }
    public function setOriginal_Service_no($original_service_no) {
        $this->original_service_no = $original_service_no;
        error_log("Original service number set to: " . $original_service_no);
    }

    // Debug function to output all properties
    public function debugOutput() {
        $data = [
            'surname' => $this->surname,
            'forename' => $this->forename,
            'address' => $this->address,
            'electoral_ward' => $this->electoral_ward,
            'town' => $this->town,
            'rank' => $this->rank,
            'regiment' => $this->regiment,
            'battalion' => $this->battalion,
            'company' => $this->company,
            'dob' => $this->dob,
            'service_no' => $this->service_no,
            'other_regiment' => $this->other_regiment,
            'other_unit' => $this->other_unit,
            'other_service_no' => $this->other_service_no,
            'medals' => $this->medals,
            'enlistment_date' => $this->enlistment_date,
            'discharge_date' => $this->discharge_date,
            'date' => $this->date,
            'misc_info_nroh' => $this->misc_info_nroh,
            'misc_info_cwgc' => $this->misc_info_cwgc,
            'cemetery_memorial' => $this->cemetery_memorial,
            'cemetery_memorial_ref' => $this->cemetery_memorial_ref,
            'cemetery_memorial_country' => $this->cemetery_memorial_country,
            'original_service_no' => $this->original_service_no
        ];
        error_log("EditGwroh data: " . json_encode($data));
        return $data;
    }

    // Method to save the object via DAO
    public function save($dao = null) {
        if ($dao === null) {
            error_log("Creating new EditDAO instance in EditGwroh save method");
            $dao = new EditDAO();
        } else {
            error_log("Using provided EditDAO instance in EditGwroh save method");
        }
        
        // Log all data before saving
        error_log("EditGwroh save: About to save with data: " . json_encode($this->debugOutput()));
        
        $result = $dao->editGwroh($this);
        error_log("EditGwroh save result: " . ($result ? "success" : "failure"));
        return $result;
    }
} 