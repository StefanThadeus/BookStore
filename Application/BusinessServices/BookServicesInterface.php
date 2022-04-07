<?php

namespace BookStore\Application\BusinessServices;
use BookStore\Application\DataAccess\Models\Book;

interface BookServicesInterface
{
    public function deleteBookById(int $id): void;
    public function addBook(Book $book): void;
    public function updateBook(string $title, int $yearOfRelease, int $id): void;
    public function getAllBooks(): array;
    public function getBookById(int $id): Book;
    public function getBookCount(): int;
    public function getAuthorByBookId(int $id): int;
    public function getBookListByAuthorId(int $id): array;
}