<?php
use PHPUnit\Framework\TestCase;
class AddGWROHTest extends TestCase {
    protected function setUp(): void {
        global $connect;
        $connect = new mysqli('localhost', 'root', '', 'WW1_Soldiers');
    }

    public function testAddGWROHInsertsRecord() {
        global $connect;

        $_POST = [
            'surnamegwroh' => 'GWTest',
            'forenamegwroh' => 'Soldier',
            'addressgwroh' => 'Test Address',
            'electoralWardgwroh' => 'Ward1',
            'towngwroh' => 'Bradford',
            'rankgwroh' => 'Private',
            'regimentgwroh' => 'Test Regiment',
            'unitgwroh' => 'Unit1',
            'companygwroh' => 'CompanyA',
            'agegwroh' => '25',
            'serviceNogwroh' => 'TST-GWROH-1',
            'otherRegimentgwroh' => '',
            'otherUnitgwroh' => '',
            'otherServiceNogwroh' => '',
            'medalsgwroh' => 'MedalX',
            'enlistmentDategwroh' => '1914-08-01',
            'dischargeDategwroh' => '1918-11-11',
            'deathDategwroh' => '1918-11-11',
            'miscInfogwroh' => 'Served in France',
            'cemeteryMemorialgwroh' => 'Cemetery X',
            'cemeteryMemorialRefgwroh' => 'Ref123',
            'cemeteryMemorialCountrygwroh' => 'UK',
            'additionalCWGCgwroh' => 'None'
        ];

        add_GWROH();

        $result = $connect->query("SELECT * FROM GWROH WHERE Service_no = 'TST-GWROH-1'");
        $this->assertEquals(1, $result->num_rows);
    }

    protected function tearDown(): void {
        global $connect;
        $connect->query("DELETE FROM GWROH WHERE Service_no = 'TST-GWROH-1'");
        $connect->close();
    }
}
?>