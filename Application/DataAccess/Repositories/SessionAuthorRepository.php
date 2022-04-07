<?php

namespace BookStore\Application\DataAccess\Repositories;
use BookStore\Application\BusinessServices\AuthorRepositoryInterface;
use BookStore\Application\DataAccess\Models\Author;

class SessionAuthorRepository implements AuthorRepositoryInterface
{
    // returns Author record with the given ID
    public function getAuthorById(int $id): Author
    {
        return $_SESSION['authorsList'][$id];
    }

    // returns collection of all Author records
    public function getAllAuthors(): array
    {
        return $_SESSION['authorsList'];
    }

    // returns total count of all Author records
    public function getAuthorCount(): int
    {
        return $_SESSION['numOfAuthors'];
    }

    // adds Author to collection and updates total number of Author records
    public function addAuthor(Author $author): void
    {
        $authorsList = $_SESSION['authorsList'];
        $author->setId($_SESSION['numOfAuthors']);
        array_push($authorsList, $author);
        $_SESSION['numOfAuthors'] += 1;
        $_SESSION['authorsList'] = $authorsList;
    }

    // updates Author record with the given ID
    public function updateAuthor(string $firstName, string $lastName, int $id): void
    {
        $authorList = $_SESSION['authorsList'];
        $authorList[$id]->setFirstName($firstName);
        $authorList[$id]->setLastName($lastName);
        $_SESSION['authorsList'] = $authorList;
    }

    // marks Author record with the given ID as deleted
    public function deleteAuthorById(int $id): void
    {
        $authorsList = $_SESSION['authorsList'];
        for ($key = 0; $key < $_SESSION['numOfAuthors']; $key++){
            if(isset($authorsList[$key])){
                if ($authorsList[$key]->getId() == $id){
                    unset($authorsList[$key]);
                }
            }
        }
        $_SESSION['authorsList'] = $authorsList;
    }

    // increases Author's book count by 1
    public function increaseAuthorBookCount(int $id): void
    {
        $authorList = $_SESSION['authorsList'];
        $authorList[$id]->increaseBookCount();
        $_SESSION['authorsList'] = $authorList;
    }

    // decreases Author's book count by 1
    public function decreaseAuthorBookCount(int $id): void
    {
        $authorList = $_SESSION['authorsList'];
        $authorList[$id]->decreaseBookCount();
        $_SESSION['authorsList'] = $authorList;
    }
}