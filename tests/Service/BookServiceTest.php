<?php

namespace App\Tests\Service;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListItem;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Service\BookService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\ArrayCollection;

class BookServiceTest extends AbstractTestCase
{
    public function testGetBooksByCategoryNotFound(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);

        $bookCategoryRepository->expects($this->once())
            ->method('existsById')
            ->with(130)
            ->willReturn(false);

        $this->expectException(BookCategoryNotFoundException::class);

        (new BookService($bookCategoryRepository, $bookRepository))->getBooksByCategory(130);
    }

    public function testGetBooksByCategory(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);

        $bookRepository->expects($this->once())
            ->method('getBooksByCategoryId')
            ->with(123)
            ->willReturn([$this->createBookEntity()]);

        $bookCategoryRepository->expects($this->once())
            ->method('existsById')
            ->with(123)
            ->willReturn(true);

        $service = new BookService($bookCategoryRepository, $bookRepository);
        $expected = new BookListResponse([$this->createBookItemModel()]);

        $this->assertEquals($expected, $service->getBooksByCategory(123));
    }

    private function createBookEntity(): Book
    {
        $book = (new Book())
            ->setTitle('Test')
            ->setSlug('test')
            ->setMeap(false)
            ->setAuthors(['Tester'])
            ->setImage('http://localhost/test.png')
            ->setCategories(new ArrayCollection())
            ->setPublicationDate(new \DateTime('2023-07-07'));
        $this->setEntityId($book, 123);

        return $book;
    }

    private function createBookItemModel(): BookListItem
    {
        $bookListItem = (new BookListItem())
            ->setTitle('Test')
            ->setSlug('test')
            ->setMeap(false)
            ->setAuthors(['Tester'])
            ->setImage('http://localhost/test.png')
            ->setPublicationDate(1688688000);
        $this->setEntityId($bookListItem, 123);

        return $bookListItem;
    }
}
