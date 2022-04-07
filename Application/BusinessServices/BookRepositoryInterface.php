<?php

namespace BookStore\Application\BusinessServices;
use BookStore\Application\DataAccess\Models\Book;

interface BookRepositoryInterface
{
    public function getBookById(int $id): Book;
    public function getAuthorByBookId(int $id): int;
    public function getBookListByAuthorId(int $id): array;
    public function getAllBooks(): array;
    public function getBookCount(): int;
    public function addBook(Book $book): void;
    public function updateBook(string $title, int $year, int $id): void;
    public function deleteBookById(int $id): void;
}