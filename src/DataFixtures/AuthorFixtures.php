<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        #one author with 100000 book
        $book_count = 100000;
        $author = new Author();
        $author->setName('the_Author_' . $book_count);
        for ($i = 0; $i < $book_count; $i++){
            /** @var Book $book */
            $book = $this->getReference('the_' . Book::class . '_' . $i);
            $author->setBook($book);
        }
        $this->addReference('the_' . Author::class, $author);
        $manager->persist($author);


        #more authors
        for ($i = 0; $i < 3; $i++) {
            $author = new Author();
            $author->setName('Author_' . $i);
            $book = $this->getReference(Book::class . '_' . $i);
            $author->setBook($book);
            $manager->persist($author);
            $this->addReference(Author::class . '_' . $i, $author);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BookFixtures::class
        );
    }
}
