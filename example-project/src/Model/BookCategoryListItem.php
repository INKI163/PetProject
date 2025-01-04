<?php

namespace App\Model;

class BookCategoryListItem
{
    private int $id;

    private string $title;

    private string $slug;

    /**
     * @param int $id
     * @param string $slug
     * @param string $title
     */
    public function __construct(int $id, string $slug, string $title)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


}
