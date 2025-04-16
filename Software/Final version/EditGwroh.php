<?php

require_once 'DBconnect.php';
require_once 'function.php';

class Edit {
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
    private $death_date;
    private $misc_info_nroh;
    private $cemetery_memorial;
    private $cemetery_memorial_ref;
    private $cemetery_memorial_country;
    private $misc_info_cwgc;

    // Getters and Setters
    public function getSurname() { return $this->surname; }
    public function setSurname($surname) { $this->surname = $surname; }

    public function getForename() { return $this->forename; }
    public function setForename($forename) { $this->forename = $forename; }

    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; }

    public function getElectoralWard() { return $this->electoral_ward; }
    public function setElectoralWard($electoral_ward) { $this->electoral_ward = $electoral_ward; }

    public function getTown() { return $this->town; }
    public function setTown($town) { $this->town = $town; }

    public function getRank() { return $this->rank; }
    public function setRank($rank) { $this->rank = $rank; }

    public function getRegiment() { return $this->regiment; }
    public function setRegiment($regiment) { $this->regiment = $regiment; }

    public function getBattalion() { return $this->battalion; }
    public function setBattalion($battalion) { $this->battalion = $battalion; }

    public function getCompany() { return $this->company; }
    public function setCompany($company) { $this->company = $company; }

    public function getDoB() { return $this->dob; }
    public function setDoB($dob) { $this->dob = $dob; }

    public function getServiceNo() { return $this->service_no; }
    public function setServiceNo($service_no) { $this->service_no = $service_no; }

    public function getOtherRegiment() { return $this->other_regiment; }
    public function setOtherRegiment($other_regiment) { $this->other_regiment = $other_regiment; }

    public function getOtherUnit() { return $this->other_unit; }
    public function setOtherUnit($other_unit) { $this->other_unit = $other_unit; }

    public function getOtherServiceNo() { return $this->other_service_no; }
    public function setOtherServiceNo($other_service_no) { $this->other_service_no = $other_service_no; }

    public function getMedals() { return $this->medals; }
    public function setMedals($medals) { $this->medals = $medals; }

    public function getEnlistmentDate() { return $this->enlistment_date; }
    public function setEnlistmentDate($enlistment_date) { $this->enlistment_date = $enlistment_date; }

    public function getDischargeDate() { return $this->discharge_date; }
    public function setDischargeDate($discharge_date) { $this->discharge_date = $discharge_date; }

    public function getDeathDate() { return $this->death_date; }
    public function setDeathDate($death_date) { $this->death_date = $death_date; }

    public function getMiscInfoNroh() { return $this->misc_info_nroh; }
    public function setMiscInfoNroh($misc_info_nroh) { $this->misc_info_nroh = $misc_info_nroh; }

    public function getCemeteryMemorial() { return $this->cemetery_memorial; }
    public function setCemeteryMemorial($cemetery_memorial) { $this->cemetery_memorial = $cemetery_memorial; }

    public function getCemeteryMemorialRef() { return $this->cemetery_memorial_ref; }
    public function setCemeteryMemorialRef($cemetery_memorial_ref) { $this->cemetery_memorial_ref = $cemetery_memorial_ref; }

    public function getCemeteryMemorialCountry() { return $this->cemetery_memorial_country; }
    public function setCemeteryMemorialCountry($cemetery_memorial_country) { $this->cemetery_memorial_country = $cemetery_memorial_country; }

    public function getMiscInfoCwgc() { return $this->misc_info_cwgc; }
    public function setMiscInfoCwgc($misc_info_cwgc) { $this->misc_info_cwgc = $misc_info_cwgc; }

    public function getEdit() {
        $edit = new Edit();
        $edit->setSurname($this->surname);
        $edit->setForename($this->forename);
        $edit->setAddress($this->address);
        $edit->setElectoralWard($this->electoral_ward);
        $edit->setTown($this->town);
        $edit->setRank($this->rank);
        $edit->setRegiment($this->regiment);
        $edit->setBattalion($this->battalion);
        $edit->setCompany($this->company);
        $edit->setDoB($this->dob);
        $edit->setServiceNo($this->service_no);
        $edit->setOtherRegiment($this->other_regiment);
        $edit->setOtherUnit($this->other_unit);
        $edit->setOtherServiceNo($this->other_service_no);
        $edit->setMedals($this->medals);
        $edit->setEnlistmentDate($this->enlistment_date);
        $edit->setDischargeDate($this->discharge_date);
        $edit->setDeathDate($this->death_date);
        $edit->setMiscInfoNroh($this->misc_info_nroh);
        $edit->setCemeteryMemorial($this->cemetery_memorial);
        $edit->setCemeteryMemorialRef($this->cemetery_memorial_ref);
        $edit->setCemeteryMemorialCountry($this->cemetery_memorial_country);
        $edit->setMiscInfoCwgc($this->misc_info_cwgc);
        return $edit;
    }

    public function save() {
        $editDAO = new EditDAO();
        return $editDAO->editGwroh($this);
    }
}
