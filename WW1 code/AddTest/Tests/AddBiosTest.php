<?php
use PHPUnit\Framework\TestCase;
class AddBiosTest extends TestCase {
    protected function setUp(): void {
        global $connect;
        $connect = new mysqli('localhost', 'root', '', 'WW1_Soldiers');
    }

    public function testAddBiosInsertsRecord() {
        global $connect;

        $_POST = [
            'surname' => 'Test',
            'forename' => 'User',
            'regiment' => 'Test Regiment',
            'serviceNo' => 'TST123',
            'bioAttachment' => 'test_attachment.pdf'
        ];

        add_Bios();

        $result = $connect->query("SELECT * FROM Biography_Information WHERE Service_no = 'TST123'");
        $this->assertEquals(1, $result->num_rows);
    }

    protected function tearDown(): void {
        global $connect;
        $connect->query("DELETE FROM Biography_Information WHERE Service_no = 'TST123'");
        $connect->close();
    }
}
?>