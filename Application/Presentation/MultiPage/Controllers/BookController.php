<?php

namespace BookStore\Application\Presentation\MultiPage\Controllers;

use BookStore\Application\BusinessServices\AuthorRepositoryInterface;
use BookStore\Application\BusinessServices\AuthorServices;
use BookStore\Application\BusinessServices\AuthorServicesInterface;
use BookStore\Application\BusinessServices\BookServicesInterface;
use BookStore\Application\DataAccess\Models\Book;
use BookStore\Application\Router;

class BookController extends Controller
{
    protected AuthorServicesInterface $authorServices;
    protected BookServicesInterface $bookServices;
    private string $viewDirectory = '/Application/Presentation/MultiPage/Views/Books/';

    public function __construct(AuthorServicesInterface $authorServicesImplementation, BookServicesInterface $bookServicesImplementation)
    {
        $this->authorServices = $authorServicesImplementation;
        $this->bookServices = $bookServicesImplementation;
    }

    // changes view to book-list.php
    public function bookList(): void
    {
        $data = array(
            "bookList" => $this->getAllBooks(),
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'book-list', $data);
    }

    // changes view to book-create.php
    public function createBook(): void
    {
        $data = array(
            "titleError" => $_GET['titleError'],
            "yearError" => $_GET['yearError'],
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'book-create', $data);
    }

    // changes view to book-edit.php
    public function editBook(): void
    {
        $data = array(
            "book" => $this->getBookById($_GET['id']),
            "titleError" => $_GET['titleError'],
            "yearError" => $_GET['yearError'],
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'book-edit', $data);
    }

    // changes view to book-confirm-delete.php
    public function confirmDeleteBook(): void
    {
        $data = array(
            "book" => $this->getBookById($_GET['id']),
            "baseURL" => Router::getBaseURL(),
        );
        $this->view($this->viewDirectory . 'book-confirm-delete', $data);
    }

    // deletes book record with the given ID from the database
    public function deleteBook(): void
    {
        $authorId = $this->getBookById(intval($_GET['id']))->getAuthorId();
        $this->deleteBookById(intval($_GET['id']));

        $this->authorServices->decreaseAuthorBookCount($authorId);

        $baseURL = Router::getBaseURL();

        header("LOCATION: " . $baseURL . "books/bookList");
    }

    // calls for bookServices to delete book record with the given ID from the database
    public function deleteBookById(int $id): void
    {
        $this->bookServices->deleteBookById($id);
    }

    // creates new author and adds it to the collection in the database if input is valid, updates author book count
    public function createNewBook(): void
    {

        $title = $_POST['title'];
        $year = intval($_POST['year']);
        $authorId = 0; // hard-coded since there is no way to choose author

        $titleHasError = !$this->validateTitleInput($title);
        $yearHasError = !$this->validateYearInput($year);

        $baseURL = Router::getBaseURL();

        if ($titleHasError == true || $yearHasError == true) {
            header("LOCATION: " . $baseURL . "books/createBook?titleError=" . $titleHasError. "&yearError=" . $yearHasError);
        } else {
            $newBook = new Book($title, $authorId, $year);
            $this->addBook($newBook);
            header("LOCATION: " . $baseURL . "books/bookList");

            // increases author book count
            $this->authorServices->increaseAuthorBookCount($authorId);
        }
    }

    // calls for bookServices to add book object to database collection
    private function addBook(Book $book): void
    {
        $this->bookServices->addBook($book);
    }

    // validates input, updates author and redirects to author list page if okay, else displays error on edit author page
    public function updateBook(): void
    {
        $title = $_POST['title'];
        $year = $_POST['year'];
        $id = $_GET['id'];

        $titleHasError = !$this->validateTitleInput($title);
        $yearHasError = !$this->validateYearInput($year);

        $baseURL = Router::getBaseURL();

        if ($titleHasError == true || $yearHasError == true) {
            header("LOCATION: " . $baseURL . "books/editBook?id=" . $id . "&titleError=" . $titleHasError. "&yearError=" . $yearHasError);
        } else {
            $this->editBookById($title, $year, $id);
            header("LOCATION: " . $baseURL . "books/bookList");
        }
    }

    // checks validity of the book title input, returns true if all is ok
    private function validateTitleInput(string $input): bool
    {
        $result = false;
        if (strlen($input) > 0 && strlen($input)<=250)
        {
            $result = true;
        }
        return  $result;
    }

    // checks validity of the book year input, returns true if all is ok
    private function validateYearInput(string $input): bool
    {
        $result = false;

        // check for not allowed characters
        if (!preg_match("/^-?\d+$/", $input))
        {
            return false;
        }

        // check range
        $input = intval($input);
        if ($input >= -5000 && $input <= 999999 && $input != 0)
        {
            $result = true;
        }
        return  $result;
    }

    // calls for bookServices to update the title and year of release of the book with the given ID
    private function editBookById(string $title, int $yearOfRelease, int $id): void
    {
        $this->bookServices->updateBook($title, $yearOfRelease, $id);
    }

    // calls for bookServices to return collection of all Books from the database
    public function getAllBooks(): array
    {
        return $this->bookServices->getAllBooks();
    }

    // calls for bookServices to return a single instance of Book with given ID
    public function getBookById(int $id): Book
    {
        return $this->bookServices->getBookById($id);
    }

    // calls for bookServices to return total number of Book records in the database
    public function getBookCount(): int
    {
        return $this->bookServices->getBookCount();
    }

    // calls for bookServices to return total number of Book records in the database
    public function getAuthorByBookId(int $id): int
    {
        return $this->bookServices->getAuthorByBookId($id);
    }

    // calls for bookServices to return a list of books by a given author
    public function getBookListByAuthorId(int $id): array
    {
        return $this->bookServices->getBookListByAuthorId($id);
    }
}
