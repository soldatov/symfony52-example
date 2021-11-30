<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
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

    public function load(ObjectManager $manager): void
    {
        foreach (self::BOOK_ONE as $ruBookOne => $enBookOne) {
            foreach (self::BOOK_TWO as $ruBookTwo => $enBookTwo) {
                foreach (self::BOOK_THREE as $ruBookThree => $enBookThree) {
                    $book = new Book();
                    $book->translate('ru')->setName($ruBookOne . ' и ' . $ruBookTwo . ', ' . $ruBookThree);
                    $book->translate('en')->setName($enBookOne . ' и ' . $enBookTwo . ', ' . $enBookThree);
                    $manager->persist($book);
                    $book->mergeNewTranslations();
                }
            }
        }

        $manager->flush();
    }
}
