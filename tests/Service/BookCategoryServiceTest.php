<?php

namespace App\Test\Service;

use App\Entity\BookCategory;
use App\Model\BookCategoryListItem;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;
use App\Service\BookCategoryService;
use App\Tests\AbstractTestCase;

class BookCategoryServiceTest extends AbstractTestCase
{
    public function testGetCategories(): void
    {
        $category = (new BookCategory())->setTitle('Test')->setSlug('test');
        $this->setEntityId($category, 7);

        $repository = $this->createMock(BookCategoryRepository::class);
        $repository->expects($this->once())
            ->method('findAllSortedByTitle')
            ->willReturn([$category]);

        $service = new BookCategoryService($repository);
        $expectedBookCategoryItem = (new BookCategoryListItem())->setTitle('Test')->setSlug('test');
        $this->setEntityId($expectedBookCategoryItem, 7);
        $expected = new BookCategoryListResponse([
            $expectedBookCategoryItem,
        ]);

        $this->assertEquals($expected, $service->getCategories());
    }
}
