<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Class BookTest
 *
 * Here we do our tests for the book class.
 */
class BookTest extends TestCase
{
    /**
     * method testSetTitle
     *
     * Here we test if we can set a title
     * @return void
     */
    public function testSetTitle(): void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setTitle("Test");
        $name = $book->getTitle();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }


    /**
     * method testSetISBN
     *
     * Here we test if we can set a ISBN
     * @return void
     */
    public function testSetISBN(): void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setISBN("Test");
        $name = $book->getISBN();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }

    /**
     * method testSetImage
     *
     * Here we test if we can set a image
     * @return void
     */
    public function testSetImage(): void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setImage("Test");
        $name = $book->getImage();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }

    /**
     * method testSetWriter
     *
     * Here we test if we can set a writer
     * @return void
     */
    public function testSetWriter(): void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        $book->setWriter("Test");
        $name = $book->getWriter();
        $this->assertNotEmpty($name);
        $this->assertSame("Test", $name);
    }
}
