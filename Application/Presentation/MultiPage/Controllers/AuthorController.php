<?php

namespace BookStore\Application\Presentation\MultiPage\Controllers;

use BookStore\Application\BusinessServices\AuthorServicesInterface;
use BookStore\Application\BusinessServices\BookRepositoryInterface;
use BookStore\Application\BusinessServices\BookServices;
use BookStore\Application\BusinessServices\BookServicesInterface;
use BookStore\Application\DataAccess\Models\Author;
use BookStore\Application\Router;

class AuthorController extends Controller
{
    protected AuthorServicesInterface $authorServices;
    protected BookServicesInterface $bookServices;
    private string $viewDirectory = '/Application/Presentation/MultiPage/Views/Authors/';

    public function __construct(AuthorServicesInterface $authorServicesImplementation, BookServicesInterface $bookServicesImplementation)
    {
        $this->authorServices = $authorServicesImplementation;
        $this->bookServices = $bookServicesImplementation;
    }

    // if no controller method is specified, execute the default method
    public function defaultPage(): void
    {
        $this->authorList();
    }

    // changes view to author-list.php
    public function authorList(): void
    {
        $data = array(
            "authorList" => $this->getAllAuthors(),
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'author-list', $data);
    }

    // changes view to author-create.php
    public function createAuthor(): void
    {
        $data = array(
            "firstNameError" => $_GET['firstNameError'],
            "lastNameError" => $_GET['lastNameError'],
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'author-create', $data);
    }

    // changes view to author-edit.php
    public function editAuthor(): void
    {
        $data = array(
            "author" => $this->getAuthorById($_GET['id']),
            "firstNameError" => $_GET['firstNameError'],
            "lastNameError" => $_GET['lastNameError'],
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'author-edit', $data);
    }

    // changes view to author-confirm-delete.php
    public function confirmDeleteAuthor(): void
    {
        $data = array(
            "author" => $this->getAuthorById($_GET['id']),
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'author-confirm-delete', $data);
    }

    // changes view to author-books.php
    public function booksByAuthor(): void
    {
        $data = array(
            "author" => $this->getAuthorById($_GET['id']),
            "bookList" => $this->bookServices->getBookListByAuthorId($_GET['id']),
            "baseURL" => Router::getBaseURL(),
            );
        $this->view($this->viewDirectory . 'author-books', $data);
    }

    // calls for author and book record deletion and redirects to homepage
    public function deleteAuthor(): void
    {
        $this->deleteAuthorById(intval($_GET['id']));

        $authorBookList = $this->bookServices->getBookListByAuthorId($_GET['id']);

        foreach ($authorBookList as $book){
            $this->bookServices->deleteBookById($book->getId());
        }

        $baseURL = Router::getBaseURL();
        header("LOCATION: " . $baseURL . "authors/authorList");
    }

    // call for authorServices to delete author record with the given ID from the database
    private function deleteAuthorById(int $id): void
    {
        $this->authorServices->deleteAuthorById($id);
    }

    // creates new author and adds it to the collection in the database if input is valid
    public function createNewAuthor(): void
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        $firstNameHasError = !$this->validateNameInput($firstName);
        $lastNameHasError = !$this->validateNameInput($lastName);

        $baseURL = Router::getBaseURL();

        if ($firstNameHasError == true || $lastNameHasError == true) {
            header("LOCATION: " . $baseURL . "authors/createAuthor?firstNameError=" . $firstNameHasError. "&lastNameError=" . $lastNameHasError);
        } else {
            $newAuthor = new Author($firstName, $lastName);
            $this->addAuthor($newAuthor);
            header("LOCATION: " . $baseURL . "authors/authorList");
        }
    }

    // call for authorServices to add author object to database collection
    private function addAuthor(Author $author): void
    {
        $this->authorServices->addAuthor($author);
    }

    // validates input, updates author and redirects to author list page if okay, else displays error on edit author page
    public function updateAuthor(): void
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $id = $_GET['id'];

        $firstNameHasError = !$this->validateNameInput($firstName);
        $lastNameHasError = !$this->validateNameInput($lastName);

        $baseURL = Router::getBaseURL();

        if ($firstNameHasError == true || $lastNameHasError == true) {
            header("LOCATION: " . $baseURL . "authors/editAuthor?id=" . $id . "&firstNameError=" . $firstNameHasError. "&lastNameError=" . $lastNameHasError);
        } else {
            $this->editAuthorById($firstName, $lastName, $id);
            header("LOCATION: " . $baseURL . "authors/authorList");
        }
    }

    // checks validity of the first or last name input, returns true if all is ok
    private function validateNameInput(string $input): bool
    {
        $result = false;
        if (ctype_alpha($input) && strlen($input) > 0 && strlen($input)<=100)
        {
            $result = true;
        }
        return  $result;
    }

    // call for authorServices to update the first and last name of the author with the given ID
    private function editAuthorById(string $firstName, string $lastName, int $id): void
    {
        $this->authorServices->updateAuthor($firstName, $lastName, $id);
    }

    // calls for authorServices to return collection of all Authors from the database
    public function getAllAuthors(): array
    {
        return $this->authorServices->getAllAuthors();
    }

    // calls for authorServices to return a single instance of Author with given ID
    public function getAuthorById(int $id): Author
    {
        return $this->authorServices->getAuthorById($id);
    }

    // calls for authorServices to return total number of Author records in the database
    public function getAuthorCount(): int
    {
        return $this->authorServices->getAuthorCount();
    }

    // calls for authorServices to increase Author book count by 1
    public function increaseBookCount(int $id): void
    {
        $this->authorServices->increaseAuthorBookCount($id);
    }

    // calls for authorServices to decrease Author book count by 1
    public function decreaseBookCount(int $id): void
    {
        $this->authorServices->decreaseAuthorBookCount($id);
    }
}