<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity
 * @method string getName()
 */
class Book implements TranslatableInterface, \JsonSerializable
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class)
     * @ORM\JoinTable(name="book_author",
     *   joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     * )
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
     * @return PersistentCollection
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->translate($this->getCurrentLocale())->getName(),
        ];
    }
}
