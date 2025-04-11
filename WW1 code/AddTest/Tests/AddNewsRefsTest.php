<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Includes/DBconnect.php';
require_once __DIR__ . '/../Includes/function.php';

class AddNewsRefsTest extends TestCase {
    protected function setUp(): void {
        global $connect;
        $connect = new mysqli('localhost', 'root', 'root', 'WW1_Soldiers');
    }

    public function testAddNewsRefsInsertsRecord() {
        global $connect;

        $_POST = [
            'surnameNews' => 'NewsTest',
            'forenameNews' => 'Reporter',
            'rankNews' => 'Corporal',
            'addressNews' => '123 Street',
            'regimentNews' => 'RegimentY',
            'unitNews' => 'UnitNews',
            'articleCommentNews' => 'Mentioned in article',
            'newspaperName' => 'The Bradford Times',
            'newspaperDate' => '1942-03-14',
            'pageCol' => '3/1',
            'photoInclNews' => 'Yes'
        ];

        add_NewsRefs();

        $result = $connect->query("SELECT * FROM Newspaper_refs WHERE Surname = 'NewsTest' AND Forename = 'Reporter'");
        $this->assertEquals(1, $result->num_rows);
    }

    protected function tearDown(): void {
        global $connect;
        $connect->query("DELETE FROM Newspaper_refs WHERE Surname = 'NewsTest' AND Forename = 'Reporter'");
        $connect->close();
    }
}
?>