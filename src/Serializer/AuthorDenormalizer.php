<?php

namespace App\Serializer;

use App\Entity\Author;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @property SerializerInterface|DenormalizerInterface $serializer
 * */
class AuthorDenormalizer extends ObjectNormalizer implements CustomDenormalizerInterface, ContextAwareDenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $authorsRaw = $data;
        $author = null;

        foreach ($authorsRaw as $locale => $authorRawItem) {
            $authorRawItem = array_merge(['currentLocale' => $locale], $authorRawItem);
            $authorItem = $this->serializer->denormalize($authorRawItem, $type, null, $context);
            /** @var Author $bookItem  */

            if ($author) {
                foreach ($authorItem->getNewTranslations() as $newTranslation) {
                    $author->addTranslation($newTranslation);
                }
            } else {
                $author = $authorItem;
            }
        }

        if ($author) {
            $author->mergeNewTranslations();
        }

        return $author;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        return $type === Author::class && $format === self::FORMAT;
    }
}
