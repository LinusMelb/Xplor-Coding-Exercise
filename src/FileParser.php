<?php
namespace App;

/**
 *
 * Class to parse file into a list of commands
 *
 * @author	Linus Peng
 */
class FileParser
{
    public $filepath;

    public function __construct($filepath)
    {
        $this->filepath = $filepath;
    }

    public function readFile() {
        $file = fopen($this->filepath, "r") or die("Unable to open file..");
        $content = fread($file, filesize($this->filepath));
        fclose($file);
        return $content;
    }

    public function parseFileToCommands() {
        return explode("\n", $this->readFile());
    }
}