<?php

namespace BookStore\Application\DataAccess\Repositories;
use BookStore\Application\BusinessServices\BookRepositoryInterface;
use BookStore\Application\DataAccess\Models\Book;

class SessionBookRepository implements BookRepositoryInterface
{
    // returns Book record with the given ID
    public function getBookById(int $id): Book
    {
        return $_SESSION['booksList'][$id];
    }

    // returns collection of all Book records
    public function getAllBooks(): array
    {
        return $_SESSION['booksList'];
    }

    // returns total count of all Book records
    public function getBookCount(): int
    {
        return $_SESSION['numOfBooks'];
    }

    // adds Book to collection and updates total number of Book records
    public function addBook(Book $book): void
    {
        $bookList = $_SESSION['booksList'];
        $book->setId($_SESSION['numOfBooks']);
        array_push($bookList, $book);
        $_SESSION['numOfBooks'] += 1;
        $_SESSION['booksList'] = $bookList;
    }

    // updates Book record with the given ID
    public function updateBook(string $title, int $year, int $id): void
    {
        $bookList = $_SESSION['booksList'];
        $bookList[$id]->setTitle($title);
        $bookList[$id]->setYearOfRelease($year);
        $_SESSION['booksList'] = $bookList;
    }

    // marks Book record with the given ID as deleted
    public function deleteBookById(int $id): void
    {
        $bookList = $_SESSION['booksList'];
        for ($key = 0; $key < $_SESSION['numOfBooks']; $key++){
            if(isset($bookList[$key])){
                if ($bookList[$key]->getId() == $id){
                    unset($bookList[$key]);
                }
            }
        }
        $_SESSION['booksList'] = $bookList;
    }

    // returns Author ID for the given Book ID
    public function getAuthorByBookId(int $id): int
    {
        return $_SESSION['booksList'][$id]->getAuthorId();
    }

    // return a list of books by a given author
    public function getBookListByAuthorId($id): array
    {
        $bookList = $_SESSION['booksList'];
        $authorBookList = [];
        for ($key = 0; $key < $_SESSION['numOfBooks']; $key++){
            if(isset($bookList[$key])){
                if ($bookList[$key]->getAuthorId() == $id){
                    array_push($authorBookList, $bookList[$key]);
                }
            }
        }

        return $authorBookList;
    }
}