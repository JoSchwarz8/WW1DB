<?php
use PHPUnit\Framework\TestCase;
class AddMemorialsTest extends TestCase {
    protected function setUp(): void {
        global $connect;
        $connect = new mysqli('localhost', 'root', '', 'WW1_Soldiers');
    }

    public function testAddMemorialsInsertsRecord() {
        global $connect;

        $_POST = [
            'surnameMemorials' => 'MemTest',
            'forenameMemorials' => 'Person',
            'regimentMemorials' => 'TestReg',
            'unitMemorials' => 'UnitX',
            'memorialMemorials' => 'Memorial1',
            'memorialLocationMemorials' => 'Bradford',
            'memorialInfoMemorials' => 'Statue',
            'memorialPostcodeMemorials' => 'BD1',
            'districtMemorials' => 'DistrictX',
            'photoAvailableMemorials' => 'Yes'
        ];

        add_Memorials();

        $result = $connect->query("SELECT * FROM Memorials WHERE Surname = 'MemTest' AND Forename = 'Person'");
        $this->assertEquals(1, $result->num_rows);
    }

    protected function tearDown(): void {
        global $connect;
        $connect->query("DELETE FROM Memorials WHERE Surname = 'MemTest' AND Forename = 'Person'");
        $connect->close();
    }
}
?>
