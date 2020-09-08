<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class BookController extends AbstractFOSRestController
{
  private $entityManager;
  private $bookRepository;

  public function __construct(
    EntityManagerInterface $em,
    BookRepository $bookRepository)
  {
    $this->entityManager = $em;
    $this->bookRepository = $bookRepository;
  }

  /**
   * @Route("/books", name="all.books", methods={"GET"})
   */
  public function bookList()
  {
    $books = $this->bookRepository->findAll();

    $view = new View();
    $view->setData($books);

    return $this->handleView($view);
  }

  /**
   * @Route("/books", name="create.book", methods={"POST"})
   * @ParamConverter("book", converter="fos_rest.request_body")
   */
  public function createBook(Book $book)
  {
    $this->entityManager->persist($book);
    $this->entityManager->flush();
    $view = new View();
    $view->setData($book);

    return $this->handleView($view);
  }

  /**
   * @Route("/books/{id<\d+>}", name="update.book", methods={"PUT"})
   * @ParamConverter("newBook", converter="fos_rest.request_body")
   */
  public function updateBook(Book $newBook, int $id)
  {
    $updBook = $this->bookRepository->find($id);
    if($newBook->getTitle()){
      $updBook->setTitle($newBook->getTitle());
    }
    if ($newBook->getAuthor()) {
      $updBook->setAuthor($newBook->getAuthor());
    }
    if ($newBook->getPage()) {
      $updBook->setPage($newBook->getPage());
    }
    if ($newBook->getPublicationYear()) {
      $updBook->setPublicationYear($newBook->getPublicationYear());
    }
    if ($newBook->getTitle()) {
      $updBook->setTitle($newBook->getTitle());
    }

    $this->entityManager->persist($updBook);
    $this->entityManager->flush();

    $view = new View();
    $view->setData($updBook);

    return $this->handleView($view);
  }

  /**
   * @Route("/books/{id<\d+>}", name="delete.book", methods={"DELETE"})
   */
  public function deleteBook(Book $book)
  {
    $this->entityManager->remove($book);
    $this->entityManager->flush();

    return new Response(1);
  }

  /**
   * @Route("/books/{id<\d+>}", name="book", methods={"GET"})
   */
  public function showBook(Book $book)
  {
    $view = new View();
    $view->setData($book);

    return $this->handleView($view);
  }
}