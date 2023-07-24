<?php

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use Doctrine\Common\Collections\ArrayCollection;

class BookControllerTest extends AbstractControllerTest
{

    public function testBooksByCategory(): void
    {
        $categoryId = $this->createCategory();

        $this->client->request('GET', '/api/v1/category/' . $categoryId . '/books');
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($response, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'publicationDate'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'title' => ['type' => 'string'],
                        'slug' => ['type' => 'string'],
                        'image' => ['type' => 'string'],
                        'authors' => [
                            'type' => 'array',
                            'items' => ['type' => 'string']
                        ],
                        'meap' => ['type' => 'boolean'],
                        'publicationDate' => ['type' => 'integer'],
                    ]
                ]
            ]
        ]);
    }

    private function createCategory(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($bookCategory);
        $this->em->persist((new Book())
            ->setPublicationDate(new \DateTime())
            ->setAuthors(['author'])
            ->setMeap(false)
            ->setSlug('test')
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setTitle('Test')
            ->setImage('http://localhost/test.png'));
        $this->em->flush();

        return $bookCategory->getId();
    }
}
