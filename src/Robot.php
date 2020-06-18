<?php

namespace App;

class Robot
{
    public const NORTH = "NORTH";
    public const SOUTH = "SOUTH";
    public const WEST = "WEST";
    public const EAST = "EAST";
    public $directionArray = array(self::NORTH, self::EAST, self::SOUTH, self::WEST);

    public $x, $y, $faceDirection;
    public $maxX, $maxY;

    public function __construct(){}

    public function setMoveArea($maxX, $maxY) {
        $this->maxX = $maxX;
        $this->maxY = $maxY;
    }

    public function place($x, $y, $faceDirection)
    {
        if ($x <= $this->maxX && $y < $this->maxY) {
            $this->x = $x;
            $this->y = $y;
            $this->faceDirection = $faceDirection;
        }
    }

    public function move()
    {
        if ($this->faceDirection == self::NORTH) {
            $this->y < $this->maxY ? $this->y++ : $this->y;
        }
        elseif ($this->faceDirection == self::SOUTH) {
            $this->y > 0 ? $this->y-- : $this->y;
        }
        elseif ($this->faceDirection == self::WEST) {
            $this->x > 0 ? $this->x-- : $this->x;
        }
        elseif ($this->faceDirection == self::EAST) {
            $this->x < $this->maxX ? $this->x++ : $this->x;
        }
    }

    public function rotateLeft()
    {
        $index = array_search($this->faceDirection, $this->directionArray);
        $this->faceDirection = $this->directionArray[$index == 0 ? sizeof($this->directionArray) -1 : $index - 1];
    }

    public function rotateRight()
    {
        $index = array_search($this->faceDirection, $this->directionArray);
        $this->faceDirection = $this->directionArray[$index == sizeof($this->directionArray) - 1 ? 0 : $index + 1];
    }

    public function report()
    {
        if (isset($this->x) && isset($this->y) && isset($this->faceDirection)) {
            return "$this->x,$this->y,$this->faceDirection";
        }
        return "";
    }

    public function executeCommand($command) {;

        if ($command == "MOVE"){
            $this->move();
        }
        elseif ($command == "LEFT") {
            $this->rotateLeft();
        }
        elseif ($command == "RIGHT") {
            $this->rotateRight();
        }
        elseif ($command == "REPORT") {
            echo $this->report() == "" ? "" : $this->report() . "\n";
        }
        elseif (preg_match('/^PLACE\s(\d),(\d),(EAST|WEST|SOUTH|NORTH)$/i', $command, $matches)) {
            $this->place($matches[1], $matches[2], $matches[3]);
        }

    }

}