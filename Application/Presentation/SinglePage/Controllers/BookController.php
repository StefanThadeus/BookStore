<?php

namespace BookStore\Application\Presentation\SinglePage\Controllers;

use BookStore\Application\BusinessServices\AuthorServices;
use BookStore\Application\BusinessServices\AuthorServicesInterface;
use BookStore\Application\BusinessServices\BookServicesInterface;
use BookStore\Application\DataAccess\Models\Book;

class BookController extends Controller
{
    protected AuthorServicesInterface $authorServices;
    protected BookServicesInterface $bookServices;

    public function __construct(AuthorServicesInterface $authorServicesImplementation, BookServicesInterface $bookServicesImplementation)
    {
        $this->authorServices = $authorServicesImplementation;
        $this->bookServices = $bookServicesImplementation;
    }

    // deletes book record with the given ID from the database
    public function deleteBook(): void
    {
        $authorId = $this->getBookById(intval($_GET['id']))->getAuthorId();
        $this->deleteBookById(intval($_GET['id']));

        $this->authorServices->decreaseAuthorBookCount($authorId);

        echo true;
    }

    // calls for bookServices to delete book record with the given ID from the database
    public function deleteBookById(int $id): void
    {
        $this->bookServices->deleteBookById($id);
    }

    // creates new author and adds it to the collection in the database if input is valid, updates author book count
    public function createNewBook(): void
    {
        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $jsonObject = json_decode($json, true);

        $title = $jsonObject['title'];
        $year = intval($jsonObject['year']);
        $authorId = 0; // hard-coded since there is no way to choose author

        $titleHasError = !$this->validateTitleInput($title);
        $yearHasError = !$this->validateYearInput($year);

        $hasError = false;
        if ($titleHasError == true) {
            $hasError = true;
        }
        if ($yearHasError == true) {
            $hasError = true;
        }

        if($hasError == true){
            // ajax success status
            $errorJSON = array('titleHasError' => $titleHasError, 'yearHasError' => $yearHasError);
            echo json_encode($errorJSON);
        } else {
            $newBook = new Book($title, $authorId, $year);
            $this->addBook($newBook);

            // increases author book count
            $this->authorServices->increaseAuthorBookCount($authorId);

            // ajax success status
            echo true;
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
        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $jsonObject = json_decode($json, true);

        $title = $jsonObject['title'];
        $year = intval($jsonObject['year']);
        $id = $_GET['id'];

        $titleHasError = !$this->validateTitleInput($title);
        $yearHasError = !$this->validateYearInput($year);

        $hasError = false;
        if ($titleHasError == true) {
            $hasError = true;
        }
        if ($yearHasError == true) {
            $hasError = true;
        }

        if($hasError == true){
            // ajax success status
            $errorJSON = array('titleHasError' => $titleHasError, 'yearHasError' => $yearHasError);
            echo json_encode($errorJSON);
        } else {
            $this->editBookById($title, $year, (int)$id);
            // ajax success status
            echo true;
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

    // calls for bookServices to return a list of books by a given author, which is then returned as a JSON file
    public function ajaxGetBookListByAuthorId(): void
    {
        $id = $_GET['id'];
        $bookList = $this->bookServices->getBookListByAuthorId($id);

        $list = array();
        foreach ($bookList as $book) {
            $list[] = array('id' => $book->getId(), 'title' => $book->getTitle(), 'yearOfRelease' => $book->getYearOfRelease());
        }
        echo json_encode($list);
    }

    // returns book record as JSON file
    public function ajaxGetBookById(): void
    {
        $book = $this->bookServices->getBookById($_GET['id']);
        $bookJSON = array('id' => $book->getId(), 'title' => $book->getTitle(), 'yearOfRelease' => $book->getYearOfRelease());
        echo json_encode($bookJSON);
    }

    // calls for bookServices to return a list of books by a given author
    public function getBookListByAuthorId(int $id): array
    {
        return $this->bookServices->getBookListByAuthorId($id);
    }

    // calls for bookServices to return collection of all Authors from the database
    public function ajaxGetBookList(): void
    {
        $bookList = $this->bookServices->getAllBooks();

        $list = array();
        foreach ($bookList as $book) {
            $list[] = array('id' => $book->getId(), 'title' => $book->getTitle(), 'yearOfRelease' => $book->getYearOfRelease());
        }
        echo json_encode($list);
    }
}
