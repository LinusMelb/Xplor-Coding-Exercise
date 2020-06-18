<?php
require_once("vendor/autoload.php");
use App\FileParser;
use PHPUnit\Framework\TestCase;

class FileParserTest extends TestCase
{
    
    public $testFilePath = 'tests/testInput.txt';

    public function testCreatingFileParser() 
    {
        $fileParser = new FileParser($testFilePath);
        $this->assertEquals($testFilePath, $fileParser->filepath);
    }

    public function testReadFile() 
    {
        $fileParser = new FileParser($this->testFilePath);
        $this->assertEquals("PLACE 1,2,EAST\nMOVE\nREPORT", $fileParser->readFile());
    }

    public function testParseFileToCommands() 
    {
        $fileParser = new FileParser($this->testFilePath);
        $this->assertEquals(
            array(
                "PLACE 1,2,EAST",
                "MOVE",
                "REPORT",
            ), $fileParser->parseFileToCommands());
    }

}