<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as API;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BooksController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/{locale}/books/{id<\d+>}", name="books_get", methods={"GET"}, requirements={
     *   "locale": "en|ru",
     * })
     *
     * @API\Get(
     *   description="Получить книгу",
     *   operationId="getBook",
     *
     *   @API\Parameter(
     *     name="id",
     *     in="path",
     *     description="Идентификатор книги",
     *     required=true,
     *     example=42
     *   ),
     *
     *   @API\Parameter(
     *     name="locale",
     *     in="path",
     *     description="Язык запроса",
     *     required=true,
     *     example="ru"
     *   ),
     * )
     * */
    public function getBook(string $locale, int $id): JsonResponse
    {
        $book = $this->em->getRepository(Book::class)->find($id);
        /** @var Book $book */

        if (empty($book)) {
            return new JsonResponse('Book no found.', Response::HTTP_NOT_FOUND);
        }

        $book->setCurrentLocale($locale);

        return new JsonResponse($book);
    }
}
