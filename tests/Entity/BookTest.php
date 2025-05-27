<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BookTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testSetTitle()
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setTitle("Test");
        $name = $book->getTitle();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }


    public function testSetISBN()
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setISBN("Test");
        $name = $book->getISBN();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }


        public function testSetImage()
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setImage("Test");
        $name = $book->getImage();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }


        public function testSetWriter()
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setWriter("Test");
        $name = $book->getWriter();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }
}
