<?php

namespace BookStore\Application\DataAccess\Models;

/* Author class definition */

class Author
{
    // Properties
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $bookCount;

    // Methods
    public function __construct(string $firstName, string $lastName, int $bookCount = 0)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->bookCount = $bookCount;
    }

    // setter for private field "firstName"
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    // getter for private field "firstName"
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    // setter for private field "lastName"
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    // getter for private field "lastName"
    public function getLastName(): string
    {
        return $this->lastName;
    }

    // setter for private field "bookCount"
    public function setBookCount(int $bookCount): void
    {
        $this->bookCount = $bookCount;
    }

    // increases "bookCount" field by 1
    public function increaseBookCount(): void
    {
        $this->bookCount++;
    }

    // decreases "bookCount" field by 1
    public function decreaseBookCount(): void
    {
        $this->bookCount--;
    }

    // getter for private field "bookCount"
    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    // setter for private field "id"
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // getter for private field "bookCount"
    public function getId(): int
    {
        return $this->id;
    }
}
