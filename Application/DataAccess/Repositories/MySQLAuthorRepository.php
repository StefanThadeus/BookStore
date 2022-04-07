<?php

namespace BookStore\Application\DataAccess\Repositories;
use BookStore\Application\BusinessServices\AuthorRepositoryInterface;
use BookStore\Application\DataAccess\Models\Author;
use BookStore\config\DatabaseConnection;
use PDO;

class MySQLAuthorRepository implements AuthorRepositoryInterface
{
    // Properties
    private PDO $db;

    // Methods
    public function __construct()
    {
        // Get connection instance
        $this->db = DatabaseConnection::getInstance();
    }

    // returns Author record with the given ID
    public function getAuthorById(int $id): Author
    {
        $statement = $this->db->prepare("SELECT * FROM Author WHERE idAuthor = " . $id);
        $statement->execute();

        $row = $statement->fetch();
        $authorId = $row['idAuthor'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $bookCount = $row['bookCount'];

        $author = new Author($firstName, $lastName, $bookCount);
        $author->setId($authorId);

        return $author;
    }

    // returns collection of all Author records
    public function getAllAuthors(): array
    {
        $authorList = [];
        $statement = $this->db->prepare("SELECT * FROM Author");
        $statement->execute();

        while ($row = $statement->fetch()) {
            $id = $row['idAuthor'];
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $bookCount = $row['bookCount'];

            $author = new Author($firstName, $lastName, $bookCount);
            $author->setId($id);
            array_push($authorList, $author);
        }

        return $authorList;
    }

    // returns total count of all Author records
    public function getAuthorCount(): int
    {
        $statement = $this->db->prepare("SELECT COUNT(*) FROM Author");
        $statement->execute();

        $row = $statement->fetch();
        return $row['COUNT(*)'];
    }

    // adds Author to collection
    public function addAuthor(Author $author): void
    {
        $firstName = $author->getFirstName();
        $lastName = $author->getLastName();
        $bookCount = $author->getBookCount();

        $query = "INSERT INTO Author (firstName, lastName, bookCount) VALUES (?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->execute([$firstName, $lastName, $bookCount]);
    }

    // updates Author record with the given ID
    public function updateAuthor(string $firstName, string $lastName, int $id): void
    {
        $query = "UPDATE Author SET firstName=?, lastName=? WHERE idAuthor=?";
        $statement = $this->db->prepare($query);
        $statement->execute([$firstName, $lastName, $id]);
    }

    // deletes Author record with the given ID
    public function deleteAuthorById(int $id): void
    {
        $query = "DELETE FROM Author WHERE idAuthor=?";
        $statement= $this->db->prepare($query);
        $statement->execute([$id]);
    }

    // increases Author's book count by 1
    public function increaseAuthorBookCount(int $id): void
    {
        $statement = $this->db->prepare("SELECT * FROM Author WHERE idAuthor = " . $id);
        $statement->execute();

        $row = $statement->fetch();
        $bookCount = $row['bookCount'];

        $bookCount++;

        $query = "UPDATE Author SET bookCount=? WHERE idAuthor=?";
        $statement = $this->db->prepare($query);
        $statement->execute([$bookCount, $id]);
    }

    // decreases Author's book count by 1
    public function decreaseAuthorBookCount(int $id): void
    {
        $statement = $this->db->prepare("SELECT * FROM Author WHERE idAuthor = " . $id);
        $statement->execute();

        $row = $statement->fetch();
        $bookCount = $row['bookCount'];

        $bookCount--;

        $query = "UPDATE Author SET bookCount=? WHERE idAuthor=?";
        $statement = $this->db->prepare($query);
        $statement->execute([$bookCount, $id]);
    }
}