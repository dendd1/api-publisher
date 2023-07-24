<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $htmlCategory = $this->getReference(BookCategoryFixtures::HTML_CATEGORY);
        $cssCategory = $this->getReference(BookCategoryFixtures::CSS_CATEGORY);

        $book = (new Book())
            ->setTitle('Design for Developers')
            ->setPublicationDate(new \DateTime('2019-07-01'))
            ->setMeap(false)
            ->setAuthors(['Stephanie Stimac'])
            ->setSlug('design-for-developers')
            ->setCategories(new ArrayCollection([$htmlCategory, $cssCategory]))
            ->setImage(
                'https://images.manning.com/360/480/resize/book/1/cea4eaa-2018-42b7-aee0-f870bbe960ee/Stimac-HI.png'
            );
        $manager->persist($book);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookCategoryFixtures::class,
        ];
    }
}
