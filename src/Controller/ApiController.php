<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Services\AuthentificationService;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/api/v1")
 */
class ApiController extends AbstractFOSRestController
{
  private $entityManager;
  private $bookRepository;
  private $authService;

  public function __construct(
    EntityManagerInterface $em,
    BookRepository $bookRepository,
    AuthentificationService $authService
  ) {
    $this->entityManager = $em;
    $this->bookRepository = $bookRepository;
    $this->authService = $authService;
  }

  /**
   * @Route("/books/list", name="all.books", methods={"GET"})
   */
  public function bookList()
  {
    if($this->authService->checkUsername()){
      return $this->authService->checkUsername();
    }
    $books = $this->bookRepository->findAll();

    $view = new View();
    $view->setData($books);

    return $this->handleView($view);
  }

  /**
   * @Route("/books/by-id/{id<\d+>}", name="book", methods={"GET"})
   */
  public function showBook(Book $book)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }
    $view = new View();
    $view->setData($book);

    return $this->handleView($view);
  }

  /**
   * @Route("/books/update/{id<\d+>}", name="update.book", methods={"POST"})
   * @ParamConverter("newBook", converter="fos_rest.request_body")
   */
  public function updateBook(Book $newBook, int $id)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }

    $updBook = $this->bookRepository->find($id);
    if (!$updBook){
      throw $this->createNotFoundException('The book does not exist');
    }

    if ($newBook->getTitle()) {
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
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }
    $this->entityManager->remove($book);
    $this->entityManager->flush();

    return new Response(1);
  }
}