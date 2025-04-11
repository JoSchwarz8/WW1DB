<?php
use PHPUnit\Framework\TestCase;
class AddBurialsTest extends TestCase {
    protected function setUp(): void {
        global $connect;
        $connect = new mysqli('localhost', 'root', 'root', 'WW1_Soldiers');
    }

    public function testAddBurialsInsertsRecord() {
        global $connect;

        $_POST = [
            'surnameBurials' => 'BurialTest',
            'forenameBurials' => 'Buried',
            'ageBurials' => '30',
            'medalsBurials' => 'MM',
            'dateOfDeath' => '1916-06-06',
            'rankBurials' => 'Lieutenant',
            'serviceNumber' => 'TST-BUR-1',
            'regimentBurials' => 'Regiment B',
            'unitBurials' => 'Unit B',
            'cemeteryBurials' => 'Bradford Cem',
            'graveReferenceBurials' => 'Ref B123',
            'infoBurials' => 'Buried locally'
        ];

        add_Burials();

        $result = $connect->query("SELECT * FROM Burials WHERE Service_Number = 'TST-BUR-1'");
        $this->assertEquals(1, $result->num_rows);
    }

    protected function tearDown(): void {
        global $connect;
        $connect->query("DELETE FROM Burials WHERE Service_Number = 'TST-BUR-1'");
        $connect->close();
    }
}
?>