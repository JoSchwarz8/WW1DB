<?php
use PHPUnit\Framework\TestCase;

class DeleteBiographyTest extends TestCase {
    public function testDeleteValidEntry() {
        $data = json_encode([service_number => '123456']);
        $options = ['http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $data
        ]];
        $context = stream_context_create($options);
        $result = file_get_contents("delete_biography.php", false, $context);
        $response = json_decode($result, true);
        $this->assertTrue($response['success']);
    }

    public function testDeleteMissingKey() {
        $data = json_encode([]);
        $options = ['http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $data
        ]];
        $context = stream_context_create($options);
        $result = file_get_contents("delete_biography.php", false, $context);
        $response = json_decode($result, true);
        $this->assertFalse($response['success']);
        $this->assertEquals("Missing service_number", $response['error']);
    }
}
?>
