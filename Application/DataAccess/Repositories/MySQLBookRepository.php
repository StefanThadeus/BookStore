<?php

namespace BookStore\Application\DataAccess\Repositories;
use BookStore\Application\BusinessServices\BookRepositoryInterface;
use BookStore\Application\DataAccess\Models\Book;
use BookStore\config\DatabaseConnection;
use PDO;

class MySQLBookRepository implements BookRepositoryInterface
{
    // Properties
    private PDO $db;

    // Methods
    public function __construct()
    {
        // Get connection instance
        $this->db = DatabaseConnection::getInstance();
    }

    // returns Book record with the given ID
    public function getBookById(int $id): Book
    {
        $statement = $this->db->prepare("SELECT * FROM Book WHERE idBook = " . $id);
        $statement->execute();

        $row = $statement->fetch();
        $idBook = $row['idBook'];
        $idAuthor = $row['idAuthor'];
        $title = $row['title'];
        $yearOfRelease = $row['yearOfRelease'];

        $book = new Book ($title, $idAuthor, $yearOfRelease);
        $book->setId($idBook);

        return $book;
    }

    // returns Author ID for the given Book ID
    public function getAuthorByBookId(int $id): int
    {
        $statement = $this->db->prepare("SELECT * FROM Book WHERE idBook = " . $id);
        $statement->execute();

        $row = $statement->fetch();
        return $row['idAuthor'];
    }

    // returns collection of all Book records
    public function getAllBooks(): array
    {
        $bookList = [];
        $statement = $this->db->prepare("SELECT * FROM Book");
        $statement->execute();

        while ($row = $statement->fetch()) {
            $idBook = $row['idBook'];
            $idAuthor = $row['idAuthor'];
            $title = $row['title'];
            $yearOfRelease = $row['yearOfRelease'];

            $book = new Book($title, $idAuthor, $yearOfRelease);
            $book->setId($idBook);
            array_push($bookList, $book);
        }

        return $bookList;
    }

    // returns total count of all Book records
    public function getBookCount(): int
    {
        $statement = $this->db->prepare("SELECT COUNT(*) FROM Book");
        $statement->execute();

        $row = $statement->fetch();
        return $row['COUNT(*)'];
    }

    // adds Book to collection and updates total number of Book records
    public function addBook(Book $book): void
    {
        $title = $book->getTitle();
        $authorId = $book->getAuthorId();
        $yearOfRelease = $book->getYearOfRelease();

        $query = "INSERT INTO Book (idAuthor, title, yearOfRelease) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->execute([$authorId, $title, $yearOfRelease]);
    }

    // updates Book record with the given ID
    public function updateBook(string $title, int $year, int $id): void
    {
        $query = "UPDATE Book SET title=?, yearOfRelease=? WHERE idBook=?";
        $statement = $this->db->prepare($query);
        $statement->execute([$title, $year, $id]);
    }

    // deletes Book record with the given ID
    public function deleteBookById(int $id): void
    {
        $query = "DELETE FROM Book WHERE idBook=?";
        $statement= $this->db->prepare($query);
        $statement->execute([$id]);
    }

    // return a list of books by a given author
    public function getBookListByAuthorId($id): array
    {
        $statement = $this->db->prepare("SELECT * FROM Book WHERE idAuthor = " . $id);
        $statement->execute();

        $bookListByAuthor = [];
        while ($row = $statement->fetch()) {
            $idBook = $row['idBook'];
            $idAuthor = $row['idAuthor'];
            $title = $row['title'];
            $yearOfRelease = $row['yearOfRelease'];

            $book = new Book($title, $idAuthor, $yearOfRelease);
            $book->setId($idBook);
            array_push($bookListByAuthor, $book);
        }

        return $bookListByAuthor;
    }
}