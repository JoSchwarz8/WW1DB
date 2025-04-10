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
        // Log received object for debugging
        error_log("EditBurials received: " . json_encode($editBurials->debugOutput()));
        
        // Get original service number for identifying the record
        $originalServiceNumber = $editBurials->getOriginal_Service_Number();
        
        $sql = "UPDATE Burials SET Surname=?, Forename=?, DoB=?, Medals=?, Date_of_Death=?, Rank=?, 
                Service_Number=?, Regiment=?, Battalion=?, Cemetery=?, Grave_Reference=?, Info=? 
                WHERE Service_Number=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            
            $params = [
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
                $originalServiceNumber // Use original service number for WHERE clause
            ];
            
            // Log the query and parameters for debugging
            error_log("Update Burials query: " . $sql);
            error_log("Parameters: " . json_encode($params));
            
            $stmt->execute($params);
            
            // Check if any rows were affected
            if ($stmt->rowCount() == 0) {
                error_log("No rows were updated. Record with Service_Number=" . $originalServiceNumber . " might not exist.");
                return false;
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Database error in editBurials: " . $e->getMessage());
            return false;
        }
    }

    public function editBiography($editBiography) {
        // Check if a service number is provided to determine if it's an update or insert
        $serviceNumber = $editBiography->getService_Number();
        $error = null;
        
        if (!empty($serviceNumber)) {
            // First check if the record exists
            $checkSql = "SELECT COUNT(*) as count FROM Biography_Information WHERE ServiceNo = ?";
            try {
                $pdo = $this->connect();
                $stmt = $pdo->prepare($checkSql);
                $stmt->execute([$serviceNumber]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($result['count'] > 0) {
                    // Record exists - do an UPDATE
                    $sql = "UPDATE Biography_Information SET Surname=?, Forename=?, Regiment=?, ServiceNo=?, Biography=? 
                            WHERE ServiceNo=?";
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
                    $sql = "INSERT INTO Biography_Information (Surname, Forename, Regiment, ServiceNo, Biography) 
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
                $sql = "INSERT INTO Biography_Information (Surname, Forename, Regiment, ServiceNo, Biography) 
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
        // Log received object for debugging
        error_log("EditNewsRef received: " . json_encode($editNewspaperRef->debugOutput()));
        
        // Get original values for identifying the record
        $originalSurname = $editNewspaperRef->getOriginalSurname();
        $originalForename = $editNewspaperRef->getOriginalForename();
        
        $sql = "UPDATE Newspaper_ref SET Surname=?, Forename=?, Rank=?, Address=?, Regiment=?, Battalion=?, `Article Comment`=?, 
                `Newspaper Name`=?, `Newspaper Date`=?, PageCol=?, PhotoIncl=? 
                WHERE Surname=? AND Forename=?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            
            $params = [
                $editNewspaperRef->getSurname(),
                $editNewspaperRef->getForename(),
                $editNewspaperRef->getRank(),
                $editNewspaperRef->getAddress(),
                $editNewspaperRef->getRegiment(),
                $editNewspaperRef->getUnit(), // Maps to Battalion in database
                $editNewspaperRef->getArticleComment(),
                $editNewspaperRef->getNewspaperName(),
                $editNewspaperRef->getNewspaperDate(),
                $editNewspaperRef->getPageColumn(),
                $editNewspaperRef->getPhotoIncl(),
                $originalSurname, // Use original values for WHERE clause
                $originalForename
            ];
            
            // Log the query and parameters for debugging
            error_log("Update Newspaper_ref query: " . $sql);
            error_log("Parameters: " . json_encode($params));
            
            $stmt->execute($params);
            
            // If no rows were updated, it might be a new record
            if ($stmt->rowCount() == 0) {
                // Insert a new record
                $sql = "INSERT INTO Newspaper_ref (Surname, Forename, Rank, Address, Regiment, Battalion, `Article Comment`, 
                        `Newspaper Name`, `Newspaper Date`, PageCol, PhotoIncl) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                // Remove the WHERE clause parameters
                array_pop($params);
                array_pop($params);
                
                // Log the insert query
                error_log("Insert Newspaper_ref query: " . $sql);
                error_log("Parameters: " . json_encode($params));
                
                $stmt->execute($params);
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Database error in editNewspaperRef: " . $e->getMessage());
            return false;
        }
    }

    public function editGwroh($editgwroh) {
        // Log received object for debugging
        error_log("EditGwroh received: " . json_encode($editgwroh->debugOutput()));
        
        // Get original service number for identifying the record
        $originalServiceNo = $editgwroh->getOriginal_Service_no();
        
        // Check if the original service number exists in the database
        try {
            $pdo = $this->connect();
            $checkSql = "SELECT COUNT(*) as count FROM gwroh WHERE `Service no` = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$originalServiceNo]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!isset($result['count']) || $result['count'] == 0) {
                error_log("Record with Service no = '$originalServiceNo' does not exist in the gwroh table");
                return false;
            } else {
                error_log("Record found with Service no = '$originalServiceNo'. Proceeding with update.");
            }
        } catch (PDOException $e) {
            error_log("Error checking for existing record: " . $e->getMessage());
            return false;
        }
        
        // Our SQL query - ensure field names match exactly with the database table
        $sql = "UPDATE gwroh SET 
                Surname = ?, 
                Forename = ?, 
                Address = ?, 
                `Electoral Ward` = ?, 
                Town = ?, 
                Rank = ?, 
                Regiment = ?, 
                Battalion = ?, 
                Company = ?, 
                DoB = ?, 
                `Service no` = ?, 
                `Other Regiment` = ?, 
                `Other Unit` = ?, 
                `Other Service no` = ?, 
                Medals = ?, 
                `Enlistment Date` = ?, 
                `Discharge Date` = ?, 
                `Death (in service) date` = ?, 
                `Misc info (Nroh)` = ?, 
                `Misc info (gwgc)` = ?, 
                `Cemetery/Memorial` = ?, 
                `Cemetery/Memorial Ref` = ?, 
                `Cemetery/Memorial Country` = ? 
                WHERE `Service no` = ?";

        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            
            $params = [
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
                $originalServiceNo // Use original service number for WHERE clause
            ];
            
            // Log the query and parameters for debugging
            error_log("Update gwroh query: " . $sql);
            error_log("Parameters: " . json_encode($params));
            
            $stmt->execute($params);
            
            // Check if any rows were affected
            if ($stmt->rowCount() == 0) {
                error_log("No rows were updated even though record exists. This might indicate no changes were made.");
                // Still return true if the record exists but no changes were made
                return true;
            }
            
            error_log("Successfully updated record with Service_no = '$originalServiceNo'");
            return true;
        } catch (PDOException $e) {
            error_log("Database error in editGwroh: " . $e->getMessage());
            // Log the query that failed for debugging
            error_log("Failed query: " . $sql);
            return false;
        }
    }
}
