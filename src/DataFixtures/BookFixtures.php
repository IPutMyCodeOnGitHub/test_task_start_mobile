<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        #100000 books for 0's author
        $batchSize = 10;
        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book->setTitle('Book0_' . $i);
            $book->setPage(300);
            $book->setPublicationYear(1950);

            $author = $this->getReference(Author::class . '_0');
            $book->setAuthor($author);
            $this->addReference(Book::class . '0_' . $i, $book);

            $manager->persist($book);
            if ((($i + 1) % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        #more books for other authors
        for($i = 1; $i < 3; $i++) {
            $book = new Book();
            $book->setTitle('Book_' . $i);
            $book->setPage(100);
            $book->setPublicationYear(1950 + $i);

            $author = $this->getReference(Author::class . '_' . $i);
            $book->setAuthor($author);
            $manager->persist($book);
            $this->addReference(Book::class . '_' . $i, $book);
        }
        $manager->flush();
    }
}


