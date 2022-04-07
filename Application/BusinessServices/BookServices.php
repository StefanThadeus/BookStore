<?php

namespace BookStore\Application\BusinessServices;

use BookStore\Application\DataAccess\Models\Book;

class BookServices implements BookServicesInterface
{
    protected BookRepositoryInterface $db;

    public function __construct(BookRepositoryInterface $dbImplementation)
    {
        $this->db = $dbImplementation;
    }

    // deletes book record with the given ID from the database
    public function deleteBookById(int $id): void
    {
        $this->db->deleteBookById($id);
    }

    // add book object to database collection
    public function addBook(Book $book): void
    {
        $this->db->addBook($book);
    }

    // updates the title and year of release of the book with the given ID
    public function updateBook(string $title, int $yearOfRelease, int $id): void
    {
        $this->db->updateBook($title, $yearOfRelease, $id);
    }

    // returns collection of all Books from the database
    public function getAllBooks(): array
    {
        return $this->db->getAllBooks();
    }

    // returns a single instance of Book with given ID
    public function getBookById(int $id): Book
    {
        return $this->db->getBookById($id);
    }

    // returns total number of Book records in the database
    public function getBookCount(): int
    {
        return $this->db->getBookCount();
    }

    // returns total number of Book records in the database
    public function getAuthorByBookId(int $id): int
    {
        return $this->db->getAuthorByBookId($id);
    }

    // return a list of books by a given author
    public function getBookListByAuthorId(int $id): array
    {
        return $this->db->getBookListByAuthorId($id);
    }
}