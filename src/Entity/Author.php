<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity
 * @method AuthorTranslation|TranslationInterface translate(?string $locale = null, bool $fallbackToDefault = true)
 */
class Author implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"book:get"})
     *
     * @var int
     */
    private int $id = 0;

    public function __construct()
    {
        $this->setDefaultLocale('ru');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @Groups({"book:get"})
     * @SerializedName("name")
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->translate($this->getCurrentLocale())->getName();
    }
}
