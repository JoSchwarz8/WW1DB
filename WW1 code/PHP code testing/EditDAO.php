<?php

class EditDAO {
    private $DB_HOST = 'localhost';
    private $DB_NAME = 'WW1_Soldiers';
    private $DB_USER = 'root';
    private $DB_PASS = 'root';

    private function connect() {
        try {
            $pdo = new PDO("mysql:host={$this->DB_HOST};dbname={$this->DB_NAME}", $this->DB_USER, $this->DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function testConnection() {
        $pdo = $this->connect();
        // Test query to make sure we can execute statements
        try {
            $stmt = $pdo->query("SELECT 1");
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Test query failed: " . $e->getMessage());
        }
    }

    public function edit($edit) {
        $sql = "UPDATE Bradford_Memorials SET surname=?, forename=?, regiment=?, unit=?, memorial=?, 
                memorial_location=?, memorial_info=?, memorial_postcode=?, district=?, photo_available=? 
                WHERE surname=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $edit->getSurname(),
                $edit->getForename(),
                $edit->getRegiment(),
                $edit->getUnit(),
                $edit->getMemorial(),
                $edit->getMemorial_location(),
                $edit->getMemorial_info(),
                $edit->getMemorial_postcode(),
                $edit->getDistrict(),
                $edit->getPhoto_available(),
                $edit->getSurname()
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editBurials($editBurials) {
        $sql = "UPDATE Burials SET Surname=?, Forename=?, DoB=?, Medals=?, Date_of_Death=?, Rank=?, 
                Service_Number=?, Regiment=?, Battalion=?, Cementary=?, Grave_Reference=?, Info=? 
                WHERE Service_Number=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $editBurials->getSurname(),
                $editBurials->getForename(),
                $editBurials->getDoB(),
                $editBurials->getMedals(),
                $editBurials->getDate_of_Death(),
                $editBurials->getRank(),
                $editBurials->getService_Number(),
                $editBurials->getRegiment(),
                $editBurials->getBattalion(),
                $editBurials->getCemetery(),
                $editBurials->getGrave_Reference(),
                $editBurials->getInfo(),
                $editBurials->getService_Number()
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editBiography($editBiography) {
        // Check if a service number is provided to determine if it's an update or insert
        $serviceNumber = $editBiography->getService_Number();
        $error = null;
        
        if (!empty($serviceNumber)) {
            // First check if the record exists
            $checkSql = "SELECT COUNT(*) as count FROM Biography_Information WHERE Service_no = ?";
            try {
                $pdo = $this->connect();
                $stmt = $pdo->prepare($checkSql);
                $stmt->execute([$serviceNumber]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result['count'] > 0) {
                    // Record exists - do an UPDATE
                    $sql = "UPDATE Biography_Information SET Surname=?, Forename=?, Regiment=?, Service_no=?, Biography=? 
                            WHERE Service_no=?";
                    $stmt = $pdo->prepare($sql);
                    
                    $params = [
                        $editBiography->getSurname(),
                        $editBiography->getForename(),
                        $editBiography->getRegiment(),
                        $editBiography->getService_Number(),
                        $editBiography->getBiography_attachment(),
                        $editBiography->getService_Number()
                    ];
                    
                    // Log the query and parameters for debugging
                    error_log("Update query: " . $sql);
                    error_log("Parameters: " . json_encode($params));
                    
                    $stmt->execute($params);
                } else {
                    // Record doesn't exist - do an INSERT
                    $sql = "INSERT INTO Biography_Information (Surname, Forename, Regiment, Service_no, Biography) 
                            VALUES (?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    
                    $params = [
                        $editBiography->getSurname(),
                        $editBiography->getForename(),
                        $editBiography->getRegiment(),
                        $editBiography->getService_Number(),
                        $editBiography->getBiography_attachment()
                    ];
                    
                    // Log the query and parameters for debugging
                    error_log("Insert query: " . $sql);
                    error_log("Parameters: " . json_encode($params));
                    
                    $stmt->execute($params);
                }
            } catch (PDOException $e) {
                $error = $e->getMessage();
                error_log("Database error: " . $error);
                return false;
            }
        } else {
            // No service number provided, just do an INSERT
            try {
                $pdo = $this->connect();
                $sql = "INSERT INTO Biography_Information (Surname, Forename, Regiment, Service_no, Biography) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                $params = [
                    $editBiography->getSurname(),
                    $editBiography->getForename(),
                    $editBiography->getRegiment(),
                    $editBiography->getService_Number(),
                    $editBiography->getBiography_attachment()
                ];
                
                // Log the query and parameters for debugging
                error_log("Insert query (no service number): " . $sql);
                error_log("Parameters: " . json_encode($params));
                
                $stmt->execute($params);
            } catch (PDOException $e) {
                $error = $e->getMessage();
                error_log("Database error: " . $error);
                return false;
            }
        }
        
        if ($error) {
            error_log("Operation failed with error: " . $error);
            return false;
        }
        
        return true;
    }

    public function editNewspaperRef($editNewspaperRef) {
        $sql = "UPDATE Newspaper_ref SET Surname=?, Forename=?, Rank=?, Regiment=?, Unit=?, Article_comment=?, 
                Newspaper_name=?, Newspaper_date=?, Page_Column=?, Photo_incl=? 
                WHERE Newspaper_date=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $editNewspaperRef->getSurname(),
                $editNewspaperRef->getForename(),
                $editNewspaperRef->getRank(),
                $editNewspaperRef->getRegiment(),
                $editNewspaperRef->getUnit(),
                $editNewspaperRef->getArticle_comment(),
                $editNewspaperRef->getNewspaper_name(),
                $editNewspaperRef->getNewspaper_date(),
                $editNewspaperRef->getPage_Column(),
                $editNewspaperRef->getPhoto_incl(),
                $editNewspaperRef->getNewspaper_date()
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editGwroh($editgwroh) {
        $sql = "UPDATE Newspaper_ref SET Surname=?, Forename=?, Address=?, Electoral_ward=?, Town=?, Rank=?, Regiment=?, 
                Battalion=?, Company=?, DoB=?, Service_no=?, Other_Regiment=?, Other_Unit=?, Other_Service_no=?, 
                Medals=?, Enlistment_Date=?, Discharge_Date=?, Date=?, Misc_info_Nroh=?, Misc_info_cwgc=?, 
                Cementery_Memorial=?, Cementery_Memorial_Ref=?, Cementary_Memorial_Country=? 
                WHERE Service_no=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $editgwroh->getSurname(),
                $editgwroh->getForename(),
                $editgwroh->getAddress(),
                $editgwroh->getElectoral_Ward(),
                $editgwroh->getTown(),
                $editgwroh->getRank(),
                $editgwroh->getRegiment(),
                $editgwroh->getBattalion(),
                $editgwroh->getCompany(),
                $editgwroh->getDoB(),
                $editgwroh->getService_no(),
                $editgwroh->getOther_Regiment(),
                $editgwroh->getOther_Unit(),
                $editgwroh->getOther_Service_no(),
                $editgwroh->getMedals(),
                $editgwroh->getEnlistment_Date(),
                $editgwroh->getDischarge_Date(),
                $editgwroh->getDate(),
                $editgwroh->getMisc_info_Nroh(),
                $editgwroh->getMisc_info_cwgc(),
                $editgwroh->getCemetery_Memorial(),
                $editgwroh->getCemetery_Memorial_Ref(),
                $editgwroh->getCemetery_Memorial_Country(),
                $editgwroh->getService_no()
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
