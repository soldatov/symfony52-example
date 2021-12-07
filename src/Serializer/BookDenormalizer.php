<?php

namespace App\Serializer;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @property SerializerInterface|DenormalizerInterface $serializer
 * */
class BookDenormalizer extends ObjectNormalizer implements CustomDenormalizerInterface, ContextAwareDenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $book = null;
        $booksRaw = $data;
        $authorsRaw = [];
        $authors = new ArrayCollection();

        foreach ($booksRaw as $locale => $bookRawItem) {
            if (is_array($bookRawItem['authors'])) {
                foreach ($bookRawItem['authors'] as $authorKey => $authorRawItem) {
                    $authorRawItem = array_merge(['currentLocale' => $locale], $authorRawItem);
                    $authorsRaw[$authorKey][$locale] = $authorRawItem;
                }

                unset($booksRaw[$locale]['authors']);
            }
        }

        unset($locale, $bookRawItem, $authorKey, $authorRawItem);

        foreach ($authorsRaw as $authorRawItem) {
            $author = $this->serializer->denormalize($authorRawItem, Author::class, $format, $context);

            if ($author) {
                $authors->add($author);
            }
        }

        foreach ($booksRaw as $locale => $bookRawItem) {
            $bookRawItem = array_merge(['currentLocale' => $locale], $bookRawItem);
            $bookItem = $this->serializer->denormalize($bookRawItem, $type, null, $context);
            /** @var Book $bookItem  */

            if ($book) {
                foreach ($bookItem->getNewTranslations() as $newTranslation) {
                    $book->addTranslation($newTranslation);
                }
            } else {
                $book = $bookItem;
            }
        }

        if ($book) {
            $book->mergeNewTranslations();
            $book->setAuthors($authors);
        }

        return $book;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Book::class && $format === self::FORMAT;
    }
}
