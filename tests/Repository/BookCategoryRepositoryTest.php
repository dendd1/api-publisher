<?php

namespace App\Tests\Repository;

use App\Entity\BookCategory;
use App\Repository\BookCategoryRepository;
use App\Tests\AbstractRepositoryTest;
use PHPUnit\Framework\TestCase;

class BookCategoryRepositoryTest extends AbstractRepositoryTest
{
    private BookCategoryRepository $bookCategoryRepository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->bookCategoryRepository = $this->getRepositoryForEntity(BookCategory::class);
    }

    public function testFindAllSortedByTitle(): void
    {
        $css = (new BookCategory())->setTitle('CSS')->setSlug('css');
        $bitrix = (new BookCategory())->setTitle('Bitrix')->setSlug('bitrix');
        $symfony = (new BookCategory())->setTitle('Symfony')->setSlug('symfony');

        foreach ([$bitrix, $css, $symfony] as $category) {
            $this->em->persist($category);
        }

        $this->em->flush();

        $titles = array_map(
            fn (BookCategory $bookCategory) => $bookCategory->getTitle(),
            $this->bookCategoryRepository->findAllSortedByTitle()
        );
        $this->assertEquals(['Bitrix', 'CSS', 'Symfony'], $titles);
    }
}