<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity
 * @method AuthorTranslation|TranslationInterface translate(?string $locale = null, bool $fallbackToDefault = true)
 */
class Book implements TranslatableInterface
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

    /**
     * @ORM\ManyToMany(targetEntity=Author::class)
     * @ORM\JoinTable(name="book_author",
     *   joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     * )
     *
     * @var Author[]|PersistentCollection $authors
     */
    private PersistentCollection $authors;

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

    /**
     * @Groups({"book:get"})
     * @SerializedName("authors")
     *
     * @return Author[]|PersistentCollection
     */
    public function getAuthors(): PersistentCollection
    {
        return $this->authors;
    }

    /**
     * @param PersistentCollection $authors
     */
    public function setAuthors(PersistentCollection $authors): void
    {
        $this->authors = $authors;
    }
}
