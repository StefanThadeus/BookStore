// action to take after create book click: show and fill edit form, hide table
function showCreateBook() {
    $("#page-heading").html("Create Book");
    $("#label-one").html("Title");
    $("#input-one").attr("placeholder", "Enter book title").val("");
    $("#label-two").html("Year");
    $("#input-two").attr("placeholder", "Enter book release year").val("");
    $("#form-save-button").attr("onclick", "createAuthor()");
    $("#tableSpan").hide();
    $("#error-one").hide();
    $("#error-two").hide();
    $("#editForm").show();
    $("#btn-navigation").html("Go to Book List");
    document.getElementById("form-save-button").onclick = createBook;
}

// call controller method to add created book to the database
function createBook() {
    // clear previous errors
    $("#error-one").hide();
    $("#error-two").hide();

    // extract first name and last name from input fields
    let title = $("#input-one").val();
    let year = $("#input-two").val();

    let postData =
        {
            "title":title,
            "year":year
        };

    // call function to create book
    $.ajax({
        url: '/spa/books/createNewBook',
        type: 'POST',
        contentType: 'application/json',
        data:JSON.stringify(postData),
        success: function (response) {
            let responseOBJ = JSON.parse(response)
            // validation error
            let error = false;
            if (responseOBJ.titleHasError === true){
                $("#error-one").html("Title must contain between 1 and 250 characters!").show();
                error = true;
            }
            if (responseOBJ.yearHasError === true){
                $("#error-two").html("Year must be in range [-5000, 999999], and cannot be 0!").show();
                error = true;
            }
            if (error === false){
                changeView("bookList");
            }
        },
        error: function (response) {
        }
    });
}

// action to take after edit book click: show and fill edit form, hide table
function showEditBook(bookId) {
    $("#page-heading").html("Edit Book (" + bookId + ")");
    $("#btn-navigation").html("Go to Book List");
    $("#label-one").html("Title");
    $("#input-one").attr("placeholder", "Enter book title");
    $("#label-two").html("Year");
    $("#input-two").attr("placeholder", "Enter book release year");
    $("#form-save-button").attr("onclick", "saveEditBook()");
    $("#tableSpan").hide();
    $("#error-one").hide();
    $("#error-two").hide();
    $("#editForm").show();

    $.ajax({
        url: 'http://bookstore.test/spa/books/ajaxGetBookById?id=' + bookId,
        type: 'GET',
        dataType: 'json',
        success: function (book) {
            console.log(book);
            $("#input-one").val(book.title);
            $("#input-two").val(book.yearOfRelease);
            document.getElementById("form-save-button").onclick = saveEditBook;
        },
        error: function (response) {
            alert(response);
        }
    });
}

// call controller method to save edited book
function saveEditBook() {
    // clear previous errors
    $("#error-one").hide();
    $("#error-two").hide();

    // extract id from heading
    let id = $("#page-heading").html();
    id = id.match(/\d+/);

    // extract title and year of release from input fields
    let title = $("#input-one").val();
    let year = $("#input-two").val();

    let postData =
        {
            "title":title,
            "year":year
        };

    // call function to update book
    $.ajax({
        url: '/spa/books/updateBook?id=' + id,
        type: 'POST',
        contentType: 'application/json',
        data:JSON.stringify(postData),
        success: function (response) {
            let responseOBJ = JSON.parse(response)
            // validation error
            let error = false;
            if (responseOBJ.titleHasError === true){
                $("#error-one").html("Title must contain between 1 and 250 characters!").show();
                error = true;
            }
            if (responseOBJ.yearHasError === true){
                $("#error-two").html("Year must be in range [-5000, 999999], and cannot be 0!").show();
                error = true;
            }
            if (error === false){
                changeView("bookList");
            }
        },
        error: function (response) {
        }
    });
}

// show "confirm delete" form for book
function showConfirmDeleteBook(bookId) {
    $("#page-heading").html('<img class="warning-icon" src="/Resources/Images/warning-icon.png" alt=""> Delete Book (' + bookId + ')');
    $("#tableSpan").hide();
    $("#confirmDeleteForm").show();
    $("#btn-navigation").html("Go to Book List");

    $.ajax({
        url: 'http://bookstore.test/spa/books/ajaxGetBookById?id=' + bookId,
        type: 'GET',
        dataType: 'json',
        success: function (book) {
            let message = "You are about to delete book '" + book.title + " (" + book.yearOfRelease + ")'. ";
            message += "If you proceed with this action, Application will permanently delete this book.";
            $("#delete-form-text").html(message);
            document.getElementById("form-delete-button").onclick = deleteBook;
            $("#form-cancel-button").attr("onclick", "changeView('bookList')");
        },
        error: function (book) {
            alert(book);
        }
    });
}

// call controller method to remove the selected book from the database
function deleteBook() {
    // extract id from heading
    let id = $("#page-heading").html();
    id = id.match(/\d+/);

    // call function to delete book
    $.ajax({
        url: 'http://bookstore.test/spa/books/deleteBook?id=' + id,
        type: 'DELETE',
        dataType: 'json',
        success: function (response) {
            changeView("bookList");
        },
        error: function (response) {
            alert(response);
        }
    });
}

// obtains the books by author and calls function to fill table with retrieved records
function getBooksByAuthor(id, name){
    $.ajax({
        url: 'http://bookstore.test/spa/books/ajaxGetBookListByAuthorId?id=' + id,
        type: 'POST',
        dataType: 'json',
        success: function (response) {

            fillTableBookList(response);
            $("#btn-navigation").html("Go to Author List");
            $("#page-heading").html('Book List by Author: <span class="author-name-color">' + name + '</span>');
            $("#tableSpan").show();
            $("#editForm").hide();
            $("#confirmDeleteForm").hide();
            $("#add-button").hide();
        },
        error: function (response) {
            alert(response);
        }
    });
}

// fill table with JSON data
function fillTableBookList(JSON_Data) {
    let table = document.getElementById('table');

    // delete table header if any exists
    $("#table thead").remove();

    // create new table head
    let new_thead = document.createElement('thead');

    // add row to table head
    let tr = document.createElement('tr');
    tr.innerHTML = '<th scope="col">Books</th><th scope="col" class="align-right">Actions</th>';
    new_thead.appendChild(tr);

    // insert table head into table
    table.appendChild(new_thead);

    // delete all previous rows in the table body if any exist
    $("#table tbody").remove();

    // create new table body
    let new_tbody = document.createElement('tbody');

    // fill table body rows with JSON data
    JSON_Data.forEach(function (book) {
        let tr = document.createElement('tr');

        // add book name
        tr.innerHTML = '<th><img class="avatar-image" src="/Resources/Images/book-icon.png" alt="">'
            + book.title + ' (' + book.yearOfRelease + ')</th>';

        // add action button edit
        tr.innerHTML += '<td class="align-right"><form action="javascript:showEditBook(' + book.id + ')" method="post" class="form-button">'
            + '<input type="image" class="edit-button" name="Edit-Book-Button" src="/Resources/Images/edit.png" value="Submit" alt="edit button"/></form>'

            // add action button delete
            + '<form action="javascript:showConfirmDeleteBook(' + book.id +')" method="post" class="form-button">'
            + '<input type="image" class="remove-button" name="Remove-Book-Button" src="/Resources/Images/delete.png" value="Submit" alt="remove button"/></form>';

        new_tbody.appendChild(tr);
    });

    // insert table body into table
    table.appendChild(new_tbody);
}