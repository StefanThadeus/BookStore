<?php

namespace BookStore\Application\BusinessServices;

use BookStore\Application\DataAccess\Models\Author;

class AuthorServices implements AuthorServicesInterface
{
    protected AuthorRepositoryInterface $db;

    public function __construct(AuthorRepositoryInterface $dbImplementation)
    {
        $this->db = $dbImplementation;
    }

    // deletes author record with the given ID from the database
    public function deleteAuthorById(int $id): void
    {
        $this->db->deleteAuthorById($id);
    }

    // add author object to database collection
    public function addAuthor(Author $author): void
    {
        $this->db->addAuthor($author);
    }

    // updates the first and last name of the author with the given ID
    public function updateAuthor(string $firstName, string $lastName, int $id): void
    {
        $this->db->updateAuthor($firstName, $lastName, $id);
    }

    // returns collection of all Authors from the database
    public function getAllAuthors(): array
    {
        return $this->db->getAllAuthors();
    }

    // returns a single instance of Author with given ID
    public function getAuthorById(int $id): Author
    {
        return $this->db->getAuthorById($id);
    }

    // returns total number of Author records in the database
    public function getAuthorCount(): int
    {
        return $this->db->getAuthorCount();
    }

    // increases Author book count by 1
    public function increaseAuthorBookCount(int $id): void
    {
        $this->db->increaseAuthorBookCount($id);
    }

    // decreases Author book count by 1
    public function decreaseAuthorBookCount(int $id): void
    {
        $this->db->decreaseAuthorBookCount($id);
    }
}