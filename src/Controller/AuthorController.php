<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthentificationService;
/**
 * @Route("/api/v1")
 */
class AuthorController extends AbstractFOSRestController
{
  private $entityManager;
  private $authorRepository;
  private $authService;

  public function __construct(
    EntityManagerInterface $em,
    AuthorRepository $authorRepository,
    AuthentificationService $authService)
  {
    $this->entityManager = $em;
    $this->authorRepository = $authorRepository;
    $this->authService = $authService;
  }

  /**
   * @Route("/authors", name="all.authors", methods={"GET"})
   */
  public function authorList()
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }

    $authors = $this->authorRepository->findAll();
    $bookCounts = array();
    foreach ($authors as $author) {
      $bookCounts[] = count($author->getBooks());
    }

    $view = new View();
    $view->setData($authors);

    return $this->handleView($view);
  }

  /**
   * @Route("/authors", name="create.author", methods={"POST"})
   * @ParamConverter("author", converter="fos_rest.request_body")
   */
  public function createAuthor(Author $author)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }

    $this->entityManager->persist($author);
    $this->entityManager->flush();
    $view = new View();
    $view->setData($author);

    return $this->handleView($view);
  }

  /**
   * @Route("/authors/{id<\d+>}", name="update.author", methods={"POST"})
   * @ParamConverter("newAuthor", converter="fos_rest.request_body")
   */
  public function updateAuthor(Author $newAuthor, int $id)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }

    $updAuthor = $this->authorRepository->find($id);
    if (!$updAuthor){
      throw $this->createNotFoundException('The author does not exist');
    }

    if ($newAuthor->getName()){
      $updAuthor->setName($newAuthor->getName());
    }

    $this->entityManager->persist($updAuthor);
    $this->entityManager->flush();

    $view = new View();
    $view->setData($updAuthor);

    return $this->handleView($view);
  }

  /**
   * @Route("/authors/{id<\d+>}", name="delete.author", methods={"DELETE"})
   */
  public function deleteAuthor(Author $author)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }
    $this->entityManager->remove($author);
    $this->entityManager->flush();

    return new Response(1);
  }

  /**
   * @Route("/authors/{id<\d+>}", name="show.author", methods={"GET"})
   */
  public function showAuthor(Author $author)
  {
    if ($this->authService->checkUsername()) {
      return $this->authService->checkUsername();
    }
    $view = new View();
    $view->setData($author);

    return $this->handleView($view);
  }
}
