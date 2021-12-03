<?php

namespace App\Controller;

use App\Entity\Book;
use App\Response\JsonNotFoundResponse;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as API;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class BooksController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var SerializerInterface|DenormalizerInterface|NormalizerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $this->serializer = new Serializer(
            [new ObjectNormalizer($classMetadataFactory, new MetadataAwareNameConverter($classMetadataFactory))],
            [JsonEncoder::FORMAT => new JsonEncoder()]
        );
    }

    /**
     * @Route("{_locale}/books/{id<\d+>}", name="books_get", methods={"GET"})
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
     *     name="_locale",
     *     in="path",
     *     description="Язык запроса",
     *     required=true,
     *     example="ru"
     *   ),
     *
     *   @API\Response(
     *     response=200,
     *     description="Возвращает книгу",
     *     @API\JsonContent(ref="#/components/schemas/Book"),
     *   ),
     *
     *   @API\Response(
     *     response=404,
     *     description="Книга не найдена",
     *     @API\JsonContent(ref="#/components/schemas/Error"),
     *   ),
     * )
     *
     * @throws ExceptionInterface
     */
    public function getBook(?Book $book): JsonResponse
    {
        if (empty($book)) {
            return new JsonNotFoundResponse('book');
        }

        return new JsonResponse($this->serializer->normalize(
            $book,
            JsonEncoder::FORMAT,
            [AbstractNormalizer::GROUPS => ['book:get']]
        ));
    }
}
