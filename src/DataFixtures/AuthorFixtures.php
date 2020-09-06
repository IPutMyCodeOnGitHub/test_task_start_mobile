<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $author = new Author();
            $author->setName('Author_' . $i);
            $manager->persist($author);
            $this->addReference(Author::class . '_' . $i, $author);
        }
        $manager->flush();
    }
}
