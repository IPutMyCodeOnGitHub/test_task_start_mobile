<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        #100000 books for the author
        $batchSize = 100;
        for ($i = 0; $i < 100000; $i++) {
            $book = new Book();
            $book->setTitle('the_Book_' . $i);
            $book->setPage(300);
            $book->setPublicationYear(1950);
            $this->addReference('the_' . Book::class . '_' . $i, $book);
            $manager->persist($book);
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        #more books for other authors
        for($i = 0; $i < 3; $i++) {
            $book = new Book();
            $book->setTitle('Book_' . $i);
            $book->setPage(100);
            $book->setPublicationYear(1950 + $i);
            $this->addReference(Book::class . '_' . $i, $book);
            $manager->persist($book);
        }
        $manager->flush();
    }
}


