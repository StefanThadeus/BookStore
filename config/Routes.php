<?php

use BookStore\Application\BusinessServices\AuthorServices;
use BookStore\Application\BusinessServices\BookServices;
use BookStore\Application\DataAccess\Repositories\MySQLAuthorRepository;
use BookStore\Application\DataAccess\Repositories\MySQLBookRepository;
use BookStore\Application\Presentation\MultiPage\Controllers\AuthorController as MPA_AuthorController;
use BookStore\Application\Presentation\MultiPage\Controllers\BookController as MPA_BookController;
use BookStore\Application\Presentation\SinglePage\Controllers\AuthorController as SPA_AuthorController;
use BookStore\Application\Presentation\SinglePage\Controllers\BookController as SPA_BookController;

return [
    'mpa' => [
        [
            'path' => '',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'defaultPage'
        ],
        [
            'path' => 'authors',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'authorList'
        ],
        [
            'path' => 'authors/authorList',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'authorList'
        ],
        [
            'path' => 'authors/booksByAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'booksByAuthor',
        ],
        [
            'path' => 'authors/createAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createAuthor'
        ],
        [
            'path' => 'authors/editAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'editAuthor'
        ],
        [
            'path' => 'authors/confirmDeleteAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'confirmDeleteAuthor'
        ],
        [
            'path' => 'authors/deleteAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'deleteAuthor',
        ],
        [
            'path' => 'authors/createNewAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createNewAuthor'
        ],
        [
            'path' => 'authors/updateAuthor',
            'controller' => new MPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'updateAuthor'
        ],
        [
            'path' => 'books/bookList',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'bookList'
        ],
        [
            'path' => 'books/createBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createBook'
        ],
        [
            'path' => 'books/editBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'editBook'
        ],
        [
            'path' => 'books/confirmDeleteBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'confirmDeleteBook'
        ],
        [
            'path' => 'books/deleteBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'deleteBook',
        ],
        [
            'path' => 'books/createNewBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createNewBook',
        ],
        [
            'path' => 'books/updateBook',
            'controller' => new MPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'updateBook'
        ],
    ],
    'spa' => [
        [
            'path' => 'spa',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'defaultPage'
        ],
        [
            'path' => 'spa/authors',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'mainPage'
        ],
        [
            'path' => 'spa/authors/ajaxGetAuthorList',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'ajaxGetAuthorList',
        ],
        [
            'path' => 'spa/authors/createNewAuthor',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createNewAuthor',
        ],
        [
            'path' => 'spa/authors/ajaxGetAuthorById',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'ajaxGetAuthorById',
        ],
        [
            'path' => 'spa/authors/updateAuthor',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'updateAuthor',
        ],
        [
            'path' => 'spa/authors/deleteAuthor',
            'controller' => new SPA_AuthorController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'deleteAuthor',
        ],
        [
            'path' => 'spa/books/ajaxGetBookList',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'ajaxGetBookList'
        ],
        [
            'path' => 'spa/books/createNewBook',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'createNewBook'
        ],
        [
            'path' => 'spa/books/ajaxGetBookById',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'ajaxGetBookById'
        ],
        [
            'path' => 'spa/books/ajaxGetBookListByAuthorId',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'ajaxGetBookListByAuthorId'
        ],
        [
            'path' => 'spa/books/updateBook',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'updateBook'
        ],
        [
            'path' => 'spa/books/deleteBook',
            'controller' => new SPA_BookController(new AuthorServices(new MySQLAuthorRepository()), new BookServices(new MySQLBookRepository())),
            'method' =>  'deleteBook'
        ]
    ]
];