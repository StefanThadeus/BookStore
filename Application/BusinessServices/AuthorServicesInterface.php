<?php

namespace BookStore\Application\BusinessServices;
use BookStore\Application\DataAccess\Models\Author;

interface AuthorServicesInterface
{
    public function deleteAuthorById(int $id): void;
    public function addAuthor(Author $author): void;
    public function updateAuthor(string $firstName, string $lastName, int $id): void;
    public function getAllAuthors(): array;
    public function getAuthorById(int $id): Author;
    public function getAuthorCount(): int;
    public function increaseAuthorBookCount(int $id): void;
    public function decreaseAuthorBookCount(int $id): void;
}