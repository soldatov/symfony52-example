<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Denismitr\Translit\Translit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const BOOK_ONE = [
        'Война' => 'War',
        'Гарри Поттер' => 'Harry Potter',
        'Шерлок Холмс' => 'Sherlock Holmes',
        'Человек без цели' => 'A man without a goal',
        'Алая роза' => 'Red rose',
        'Мир лжецов' => 'World of Liars',
        'Ключ к бессмертию' => 'The key to immortality',
        'Тени за спиной' => 'Shadows Behind',
        'Сладкий поцелуй' => 'Sweet kiss',
        'Секрет ведьм' => 'The secret of witches',
        'Шёпот цветов' => 'Whisper of flowers',
        'Тайный мир' => 'Secret World',
        'Огненное озеро' => 'Lake of Fire',
        'Солнечный город' => 'Sunny city',
        'Мечтатели' => 'The dreamers',
        'Остров желаний' => 'Island of desires',
    ];

    private const BOOK_TWO = [
        'мир' => 'world',
        'философский камень' => 'philosophers stone',
        'доктор Ватсон' => 'Dr. Watson',
        'последний сон' => 'last dream',
        'биография неизвестного' => 'biography of an unknown',
        'братство смерти' => 'brotherhood of death',
        'необычные каникулы' => 'unusual holidays',
        'солнце на вершине xолма' => 'sun at the top of the hill',
        'свет в океане' => 'light in the ocean',
        'заброшенный лес' => 'abandoned forest',
        'один шаг назад' => 'one step back',
        'алая роза' => 'scarlet rose',
        'погоня за клинком' => 'chasing the blade',
        'фрагменты прошлого' => 'fragments of the past',
        'шелест страниц' => 'rustling pages',
        'секрет пустых коридоров' => 'secret of empty corridors',
        'параллельный мир' => 'parallel world',
    ];

    private const BOOK_THREE = [
        'часть 1' => 'part 1',
        'часть 2' => 'part 2',
        'часть 3' => 'part 3',
        'часть 4' => 'part 4',
        'часть 5' => 'part 5',
        'часть 6' => 'part 6',
        'часть 7' => 'part 7',
        'часть 8' => 'part 8',
        'часть 9' => 'part 9',
        'часть 10' => 'part 10',
        'переиздание' => 'reprint',
        'переиздание второе' => 'reprint second',
        'расширенное издание' => 'extended edition',
        'краткое содержание' => 'summary',
        'краткое изложение' => 'opus',
        'сборник фанфиков' => 'collection of fanfiction',
        'сценарий' => 'film script',
        'альтернативный перевод' => 'alternative translation',
        'электронная версия' => 'electronic version',
    ];

    private const AUTHOR_NAMES = [
        'Александр',
        'Сергей',
        'Владимир',
        'Андрей',
        'Алексей',
        'Николай',
        'Иван',
        'Дмитрий',
        'Михаил',
        'Евгений',
        'Виктор',
        'Юрий',
        'Василий',
        'Игорь',
        'Анатолий',
        'Олег',
        'Павел',
        'Максим',
        'Виталий',
        'Валерий',
        'Роман',
        'Денис',
        'Константин',
        'Вячеслав',
        'Владислав',
        'Вадим',
        'Глеб',
        'Матвей',
    ];

    private const AUTHOR_MIDDLE_NAMES = [
        'Олегович',
        'Орестович',
        'Павлович',
        'Памфилович',
        'Панкратович',
        'Абрамович',
        'Агапович',
        'Адамович',
        'Альбертович',
        'Богданович',
        'Вадимович',
        'Валерианович',
        'Валериевич',
        'Владимирович',
        'Геннадиевич',
        'Германович',
        'Глебович',
        'Григорьевич',
        'Давидович',
        'Далматович',
        'Демидович',
        'Добрынич',
        'Егорович',
        'Еремеевич',
        'Ефремович',
        'Львович',
        'Ларионович',
        'Логвинович',
        'Маратович',
        'Маркович',
        'Матвеевич',
        'Мирославович',
        'Назарович',
        'Никитич',
        'Самсонович',
    ];

    private const AUTHOR_FAMILY = [
        'Смирнов',
        'Иванов',
        'Кузнецов',
        'Соколов',
        'Попов',
        'Лебедев',
        'Козлов',
        'Новиков',
        'Морозов',
        'Петров',
        'Волков',
        'Соловьёв',
        'Васильев',
        'Зайцев',
        'Павлов',
        'Семёнов',
        'Голубев',
        'Виноградов',
        'Богданов',
        'Воробьёв',
        'Фёдоров',
        'Михайлов',
        'Беляев',
        'Тарасов',
        'Белов',
        'Комаров',
        'Орлов',
        'Киселёв',
        'Макаров',
        'Андреев',
    ];

    public function load(ObjectManager $manager): void
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $i = 0;

        foreach (self::BOOK_ONE as $ruBookOne => $enBookOne) {
            foreach (self::BOOK_TWO as $ruBookTwo => $enBookTwo) {
                foreach (self::BOOK_THREE as $ruBookThree => $enBookThree) {
                    $book = new Book();
                    $book->translate('ru')->setName($ruBookOne . ' и ' . $ruBookTwo . ', ' . $ruBookThree);
                    $book->translate('en')->setName($enBookOne . ' и ' . $enBookTwo . ', ' . $enBookThree);
                    $manager->persist($book);
                    $book->mergeNewTranslations();

                    if (++$i >= 500) {
                        $manager->flush();
                        $manager->clear();
                        $i = 0;
                    }
                }
            }
        }

        $manager->flush();
        $manager->clear();

        $i = 0;

        $translit = new Translit();

        foreach (self::AUTHOR_NAMES as $authorNameItem) {
            foreach (self::AUTHOR_MIDDLE_NAMES as $authorMiddleItem) {
                foreach (self::AUTHOR_FAMILY as $authorFamilyItem) {
                    $name = $authorNameItem . ' ' . $authorMiddleItem . ' ' . $authorFamilyItem;
                    $nameEn = ucwords(
                        $translit->transform($authorNameItem) . ' '
                        . $translit->transform($authorMiddleItem) . ' '
                        . $translit->transform($authorFamilyItem)
                    );

                    $author = new Author();
                    $author->translate('ru')->setName($name);
                    $author->translate('en')->setName($nameEn);
                    $manager->persist($author);
                    $author->mergeNewTranslations();

                    if (++$i >= 500) {
                        $manager->flush();
                        $manager->clear();
                        $i = 0;
                    }
                }
            }
        }

        $manager->flush();
        $manager->clear();

        $authorsIds = array_map(
            function ($item) {
                /** @var Author $item */

                return $item->getId();
            },
            $manager->getRepository(Author::class)->findAll()
        );

        $books = $manager->getRepository(Book::class)->findAll();
        /** @var Book[] $books */

        $i = 1;
        foreach ($books as $book) {

            for ($ii = 1; $ii <= $i; $ii++) {
                $authorID = array_shift($authorsIds);
                $author = $manager->getRepository(Author::class)->find($authorID);
                $book->getAuthors()->add($author);
            }

            $i++;

            if ($i >= 4) {
                $i = 1;
            }
        }

        $manager->flush();

        $author42 = $manager->getRepository(Author::class)->find(42);

        foreach ([42, 142, 242, 342, 442, 542, 642, 742, 1042, 1142, 1242, 1342, 1442, 1542, 1642, 1742] as $item) {
            $book = $manager->getRepository(Book::class)->find($item);
            /** @var Book $book */
            $book->getAuthors()->add($author42);
        }

        $manager->flush();
    }
}
