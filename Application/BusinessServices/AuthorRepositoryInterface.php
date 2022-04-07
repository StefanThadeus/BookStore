<?php

namespace BookStore\Application\BusinessServices;
use BookStore\Application\DataAccess\Models\Author;

interface AuthorRepositoryInterface
{
    public function getAuthorById(int $id): Author;
    public function getAllAuthors(): array;
    public function getAuthorCount(): int;
    public function addAuthor(Author $author): void;
    public function updateAuthor(string $firstName, string $lastName, int $id): void;
    public function deleteAuthorById(int $id): void;
    public function increaseAuthorBookCount(int $id): void;
    public function decreaseAuthorBookCount(int $id): void;
}