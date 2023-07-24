<?php

namespace App\Model;

class BookCategoryListItem
{
    private int $id;
    private string $title;
    private string $slug;

//    public function __construct(int $id, string $title, string $slug)
//    {
//        $this->id = $id;
//        $this->title = $title;
//        $this->slug = $slug;
//    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setId(int $id): BookCategoryListItem
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(string $title): BookCategoryListItem
    {
        $this->title = $title;
        return $this;
    }

    public function setSlug(string $slug): BookCategoryListItem
    {
        $this->slug = $slug;
        return $this;
    }


}
