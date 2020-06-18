<?php
require_once("vendor/autoload.php");
use App\Robot;
use PHPUnit\Framework\TestCase;

class RobotTest extends TestCase
{
    protected $robot;

    // This function runs before every test to init a robot instance
    public function setUp(): void {
        $this->robot = new App\Robot();
        $this->robot->setMoveArea(5, 5);
    }

    public function testSetMovableArea() {
        $this->assertTrue(5 === $this->robot->maxX);
        $this->assertTrue(5 === $this->robot->maxY);
    }

    public function testRobotCanBePlaced() {
        $this->robot->place(1, 2, 'NORTH');
        $this->assertEquals(1, $this->robot->x);
        $this->assertEquals(2, $this->robot->y);
        $this->assertEquals('NORTH', $this->robot->faceDirection);

        // Test when it's an invalid placement 
        $this->robot->place(9, 5, 'SOUTH');
        $this->assertNotEquals(9, $this->robot->x);
        $this->assertNotEquals(5, $this->robot->y);
        $this->assertNotEquals('SOUTH', $this->robot->faceDirection);
    }

    public function testRobotCanReport(){
        $this->robot->place(1, 2, 'NORTH');
        $this->assertEquals("1,2,NORTH", $this->robot->report());
        $this->robot->place(5, 3, 'SOUTH');
        $this->assertEquals("5,3,SOUTH", $this->robot->report());

        // invalid inputs
        $this->robot->place(6, 6, 'SOUTH');
        $this->assertEquals("5,3,SOUTH", $this->robot->report());
    }

    public function testRobotCanMove()
    {
        $this->robot->place(4, 1, 'EAST');
        $this->robot->move();
        $this->assertEquals(5, $this->robot->x);
        $this->assertEquals(1, $this->robot->y);

        // Test when it reaches to the boundry
        $this->robot->move();
        $this->assertEquals(5, $this->robot->x);
        $this->assertEquals(1, $this->robot->y);
    }

    public function testRobotRotateLeft() 
    {
        $this->robot->place(4, 1, 'EAST');
        $this->robot->rotateLeft();
        $this->assertEquals('NORTH', $this->robot->faceDirection);
        $this->robot->rotateLeft();
        $this->assertEquals('WEST', $this->robot->faceDirection);
        $this->robot->rotateLeft();
        $this->assertEquals('SOUTH', $this->robot->faceDirection);
        $this->robot->rotateLeft();
        $this->assertEquals('EAST', $this->robot->faceDirection);
    }

    public function testRobotRotateRight() 
    {
        $this->robot->place(4, 1, 'EAST');
        $this->robot->rotateRight();
        $this->assertEquals('SOUTH', $this->robot->faceDirection);
        $this->robot->rotateRight();
        $this->assertEquals('WEST', $this->robot->faceDirection);
        $this->robot->rotateRight();
        $this->assertEquals('NORTH', $this->robot->faceDirection);
        $this->robot->rotateRight();
        $this->assertEquals('EAST', $this->robot->faceDirection);
    }

    public function testRobotExecuteCommand() 
    {
        // invalid command
        $this->robot->executeCommand("PLACE 0,0,NORTH");
        $this->assertEquals("", $this->robot->report());
        $this->robot->executeCommand("PLACE 5,4,SOUTHWEST");
        $this->assertNotEquals("5,4,SOUTHWEST", $this->robot->report());

        // valid command
        $this->robot->executeCommand("PLACE 1,1,NORTH");
        $this->robot->executeCommand("MOVE");
        $this->robot->executeCommand("MOVE");
        $this->robot->executeCommand("MOVE");
        $this->assertEquals("1,4,NORTH", $this->robot->report());

        $this->robot->executeCommand("LEFT");
        $this->assertEquals("1,4,WEST", $this->robot->report());
        $this->robot->executeCommand("RIGHT");
        $this->assertEquals("1,4,NORTH", $this->robot->report());

        $this->robot->executeCommand("REPORT");
        $this->expectOutputString("1,4,NORTH\n");
    }

}
