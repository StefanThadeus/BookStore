<?php

namespace BookStore\Application\Presentation\SinglePage\Controllers;

use BookStore\Application\BusinessServices\AuthorServicesInterface;
use BookStore\Application\BusinessServices\BookServices;
use BookStore\Application\BusinessServices\BookServicesInterface;
use BookStore\Application\DataAccess\Models\Author;

class AuthorController extends Controller
{
    protected AuthorServicesInterface $authorServices;
    protected BookServicesInterface $bookServices;
    private string $viewDirectory = '/Application/Presentation/SinglePage/Views/';

    public function __construct(AuthorServicesInterface $authorServicesImplementation, BookServicesInterface $bookServicesImplementation)
    {
        $this->authorServices = $authorServicesImplementation;
        $this->bookServices = $bookServicesImplementation;
    }

    // if no controller method is specified, execute the default method
    public function defaultPage(): void
    {
        $this->mainPage();
    }

    // changes view to page.php
    public function mainPage(): void
    {
        $data = array(
            "authorList" => $this->getAllAuthors()
        );
        $this->view($this->viewDirectory . 'page', $data);
    }

    // calls for author and book record deletion and redirects to homepage
    public function deleteAuthor(): void
    {
        $this->deleteAuthorById($_GET['id']);

        $authorBookList = $this->bookServices->getBookListByAuthorId($_GET['id']);

        foreach ($authorBookList as $book) {
            $this->bookServices->deleteBookById($book->getId());
        }

        // ajax success status
        echo true;
    }

    // call for authorServices to delete author record with the given ID from the database
    private function deleteAuthorById(int $id): void
    {
        $this->authorServices->deleteAuthorById($id);
    }

    // creates new author and adds it to the collection in the database if input is valid
    public function createNewAuthor(): void
    {
        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $jsonObject = json_decode($json, true);

        $firstName = $jsonObject['firstName'];
        $lastName = $jsonObject['lastName'];

        $firstNameHasError = !$this->validateNameInput($firstName);
        $lastNameHasError = !$this->validateNameInput($lastName);

        $hasError = false;
        if ($firstNameHasError == true) {
            $hasError = true;
        }
        if ($lastNameHasError == true) {
            $hasError = true;
        }

        if($hasError == true){
            // ajax success status
            $errorJSON = array('firstNameHasError' => $firstNameHasError, 'lastNameHasError' => $lastNameHasError);
            echo json_encode($errorJSON);
        } else {
            $newAuthor = new Author($firstName, $lastName);
            $this->addAuthor($newAuthor);
            // ajax success status
            echo true;
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
        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $jsonObject = json_decode($json, true);

        $firstName = $jsonObject['firstName'];
        $lastName = $jsonObject['lastName'];

        $id = $_GET['id'];

        $firstNameHasError = !$this->validateNameInput($firstName);
        $lastNameHasError = !$this->validateNameInput($lastName);

        $hasError = false;
        if ($firstNameHasError == true) {
            $hasError = true;
        }
        if ($lastNameHasError == true) {
            $hasError = true;
        }

        if($hasError == true){
            // ajax success status
            $errorJSON = array('firstNameHasError' => $firstNameHasError, 'lastNameHasError' => $lastNameHasError);
            echo json_encode($errorJSON);
        }
        else {
            $this->editAuthorById($firstName, $lastName, $id);
            // ajax success status
            echo true;
        }
    }

    // checks validity of the first or last name input, returns true if all is ok
    private function validateNameInput(string $input): bool
    {
        $result = false;
        if (ctype_alpha($input) && strlen($input) > 0 && strlen($input) <= 100) {
            $result = true;
        }
        return $result;
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

    // calls for authorServices to return collection of all Authors from the database
    public function ajaxGetAuthorList(): void
    {
        $authorList = $this->authorServices->getAllAuthors();

        $list = array();
        foreach ($authorList as $author) {
            $list[] = array('id' => $author->getId(), 'firstName' => $author->getFirstName(), 'lastName' => $author->getLastName(), 'bookCount' => $author->getBookCount());
        }
        echo json_encode($list);
    }

    // return single author record
    public function ajaxGetAuthorById(): void
    {
        $author = $this->authorServices->getAuthorById($_GET['id']);
        $authorJSON = array('id' => $author->getId(), 'firstName' => $author->getFirstName(), 'lastName' => $author->getLastName(), 'bookCount' => $author->getBookCount());
        echo json_encode($authorJSON);
    }
}