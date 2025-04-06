<?php
class EditNewsRef {
    private $surname;
    private $forename;
    private $rank;
    private $address;
    private $regiment;
    private $unit;
    private $article_comment;
    private $newspaper_name;
    private $newspaper_date;
    private $page_column;
    private $photo_incl;
    private $original_newspaper_date;
    private $original_surname;
    private $original_forename;

    public function __construct() {
        // Empty constructor
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

    public function getRank() {
        return $this->rank;
    }
    public function setRank($rank) {
        $this->rank = $rank;
    }

    public function getAddress() {
        return $this->address;
    }
    public function setAddress($address) {
        $this->address = $address;
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

    public function getArticleComment() {
        return $this->article_comment;
    }
    public function setArticleComment($article_comment) {
        $this->article_comment = $article_comment;
    }

    public function getNewspaperName() {
        return $this->newspaper_name;
    }
    public function setNewspaperName($newspaper_name) {
        $this->newspaper_name = $newspaper_name;
    }

    public function getNewspaperDate() {
        return $this->newspaper_date;
    }
    public function setNewspaperDate($newspaper_date) {
        $this->newspaper_date = $newspaper_date;
    }

    public function getPageColumn() {
        return $this->page_column;
    }
    public function setPageColumn($page_column) {
        $this->page_column = $page_column;
    }

    public function getPhotoIncl() {
        return $this->photo_incl;
    }
    public function setPhotoIncl($photo_incl) {
        $this->photo_incl = $photo_incl;
    }

    public function getOriginalNewspaperDate() {
        return $this->original_newspaper_date;
    }
    public function setOriginalNewspaperDate($original_newspaper_date) {
        $this->original_newspaper_date = $original_newspaper_date;
    }

    public function getOriginalSurname() {
        return $this->original_surname;
    }
    public function setOriginalSurname($original_surname) {
        $this->original_surname = $original_surname;
    }

    public function getOriginalForename() {
        return $this->original_forename;
    }
    public function setOriginalForename($original_forename) {
        $this->original_forename = $original_forename;
    }

    // Debug function to output all properties
    public function debugOutput() {
        return [
            'surname' => $this->surname,
            'forename' => $this->forename,
            'rank' => $this->rank,
            'address' => $this->address,
            'regiment' => $this->regiment,
            'unit' => $this->unit,
            'article_comment' => $this->article_comment,
            'newspaper_name' => $this->newspaper_name,
            'newspaper_date' => $this->newspaper_date,
            'page_column' => $this->page_column,
            'photo_incl' => $this->photo_incl,
            'original_newspaper_date' => $this->original_newspaper_date,
            'original_surname' => $this->original_surname,
            'original_forename' => $this->original_forename
        ];
    }

    // Method to save the object via DAO
    public function save($dao = null) {
        if ($dao === null) {
            $dao = new EditDAO();
        }
        return $dao->editNewspaperRef($this);
    }
} 