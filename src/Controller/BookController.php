<?php

namespace App\Controller;

use App\Entity\Book;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\AuthentificationService;

/**
 * @Route("/api/v1")
 */
class BookController extends AbstractFOSRestController
{
  private $entityManager;
  private $authService;

  public function __construct(
    EntityManagerInterface $em,
    AuthentificationService $authService)
  {
    $this->entityManager = $em;
    $this->authService = $authService;
  }

  /**
   * @Route("/books", name="create.book", methods={"POST"})
   * @ParamConverter("book", converter="fos_rest.request_body")
   */
  public function createBook(Book $book)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }

    $this->entityManager->persist($book);
    $this->entityManager->flush();
    $view = new View();
    $view->setData($book);

    return $this->handleView($view);
  }
}