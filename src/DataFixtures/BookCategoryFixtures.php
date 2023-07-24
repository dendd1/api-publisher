<?php

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    public const HTML_CATEGORY = 'html';
    public const CSS_CATEGORY = 'css';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::HTML_CATEGORY => (new BookCategory())->setTitle('HTML')->setSlug('html'),
            self::CSS_CATEGORY => (new BookCategory())->setTitle('CSS')->setSlug('css'),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }
        $manager->persist((new BookCategory())->setTitle('Java')->setSlug('java'));

        $manager->flush();

        foreach ($categories as $code => $category) {
            $this->addReference($code, $category);
        }
    }
}
