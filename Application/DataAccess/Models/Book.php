<?php

namespace BookStore\Application\DataAccess\Models;

/* Book class definition */

class Book
{
    // Properties
    private int $id;
    private int $authorId;
    private string $title;
    private int $yearOfRelease;

    // Methods
    public function __construct(string $title, int $authorId, int $yearOfRelease)
    {
        $this->title = $title;
        $this->authorId = $authorId;
        $this->yearOfRelease = $yearOfRelease;
    }

    // setter for private field "title"
    public function SetTitle(string $title): void
    {
        $this->title = $title;
    }

    // getter for private field "title"
    public function getTitle(): string
    {
        return $this->title;
    }

    // setter for private field "authorId"
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // getter for private field "authorId"
    public function getId(): string
    {
        return $this->id;
    }

    // setter for private field "authorId"
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    // getter for private field "authorId"
    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    // setter for private field "yearOfRelease"
    public function setYearOfRelease(int $yearOfRelease): void
    {
        $this->yearOfRelease = $yearOfRelease;
    }

    // getter for private field "yearOfRelease"
    public function getYearOfRelease(): int
    {
        return $this->yearOfRelease;
    }
}
