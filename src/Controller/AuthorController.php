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

/**
 * @Route("/admin")
 */
class AuthorController extends AbstractFOSRestController
{
  private $entityManager;
  private $authorRepository;

  public function __construct(
    EntityManagerInterface $em,
    AuthorRepository $authorRepository)
  {
    $this->entityManager = $em;
    $this->authorRepository = $authorRepository;
  }

  /**
   * @Route("/authors", name="all.authors", methods={"GET"})
   */
  public function authorList()
  {
    $authors = $this->authorRepository->findAll();

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
    $this->entityManager->persist($author);
    $this->entityManager->flush();
    $view = new View();
    $view->setData($author);

    return $this->handleView($view);
  }

  /**
   * @Route("/authors/{id<\d+>}", name="update.author", methods={"PUT"})
   * @ParamConverter("newAuthor", converter="fos_rest.request_body")
   */
  public function updateAuthor(Author $newAuthor, int $id)
  {
    $updAuthor = $this->authorRepository->find($id);
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
    $this->entityManager->remove($author);
    $this->entityManager->flush();

    return new Response(1);
  }

  /**
   * @Route("/authors/{id<\d+>}", name="show.author", methods={"GET"})
   */
  public function showAuthor(Author $author)
  {
    $view = new View();
    $view->setData($author);

    return $this->handleView($view);
  }
}
