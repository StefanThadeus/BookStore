// action to take after create author click: show and fill edit form, hide table
function showCreateAuthor() {
    $("#page-heading").html("Create Author");
    $("#label-one").html("First name");
    $("#input-one").attr("placeholder", "Enter first name").val("");
    $("#label-two").html("Last name");
    $("#input-two").attr("placeholder", "Enter last name").val("");
    $("#form-save-button").attr("onclick", "createAuthor()");
    $("#tableSpan").hide();
    $("#error-one").hide();
    $("#error-two").hide();
    $("#editForm").show();
    $("#btn-navigation").html("Go to Author List");
    document.getElementById("form-save-button").onclick = createAuthor;
}

// call controller method to add created author to the database
function createAuthor() {
    // clear previous errors
    $("#error-one").hide();
    $("#error-two").hide();

    // extract first name and last name from input fields
    let firstName = $("#input-one").val();
    let lastName = $("#input-two").val();

    let postData =
        {
            "firstName":firstName,
            "lastName":lastName
        };

    // call function to create author
    $.ajax({
        url: '/spa/authors/createNewAuthor',
        type: 'POST',
        contentType: 'application/json',
        data:JSON.stringify(postData),
        success: function (response) {
            let responseOBJ = JSON.parse(response)
            // validation error
            let error = false;
            if (responseOBJ.firstNameHasError === true){
                $("#error-one").html("First name must contain between 1 and 100 characters!").show();
                error = true;
            }
            if (responseOBJ.lastNameHasError === true){
                $("#error-two").html("Last name must contain between 1 and 100 characters!").show();
                error = true;
            }
            if (error === false){
                changeView("authorList");
            }
        },
        error: function (response) {
        }
    });
}

// action to take after edit author click: show and fill edit form, hide table
function showEditAuthor(authorId) {
    $("#page-heading").html("Edit Author (" + authorId + ")");
    $("#label-one").html("First name");
    $("#input-one").attr("placeholder", "Enter first name");
    $("#label-two").html("Last name");
    $("#input-two").attr("placeholder", "Enter last name");
    $("#form-save-button").attr("onclick", "saveEditAuthor()");
    $("#tableSpan").hide();
    $("#error-one").hide();
    $("#error-two").hide();
    $("#editForm").show();
    $("#btn-navigation").html("Go to Author List");

    $.ajax({
        url: 'http://bookstore.test/spa/authors/ajaxGetAuthorById?id=' + authorId,
        type: 'GET',
        dataType: 'json',
        success: function (author) {
            $("#input-one").val(author.firstName);
            $("#input-two").val(author.lastName);
            document.getElementById("form-save-button").onclick = saveEditAuthor;
        },
        error: function (author) {
            alert(author);
        }
    });
}

// call controller method to save edited author
function saveEditAuthor() {
    // clear previous errors
    $("#error-one").hide();
    $("#error-two").hide();

    // extract id from heading
    let id = $("#page-heading").html();
    id = id.match(/\d+/);

    // extract first name and last name from input fields
    let firstName = $("#input-one").val();
    let lastName = $("#input-two").val();

    let postData =
        {
            "firstName":firstName,
            "lastName":lastName
        };

    // call function to save author
    $.ajax({
        url: '/spa/authors/updateAuthor?id=' + id,
        type: 'POST',
        contentType: 'application/json',
        data:JSON.stringify(postData),
        success: function (response) {
            let responseOBJ = JSON.parse(response)
            // validation error
            let error = false;
            if (responseOBJ.firstNameHasError === true){
                $("#error-one").html("First name must contain between 1 and 100 characters!").show();
                error = true;
            }
            if (responseOBJ.lastNameHasError === true){
                $("#error-two").html("Last name must contain between 1 and 100 characters!").show();
                error = true;
            }
            if (error === false){
                changeView("authorList");
            }
        },
        error: function (response) {
        }
    });
}

// show "confirm delete" form for author
function showConfirmDeleteAuthor(authorId) {
    $("#page-heading").html('<img class="warning-icon" src="/Resources/Images/warning-icon.png" alt=""> Delete Author (' + authorId + ')');
    $("#tableSpan").hide();
    $("#confirmDeleteForm").show();
    $("#btn-navigation").html("Go to Author List");

    $.ajax({
        url: 'http://bookstore.test/spa/authors/ajaxGetAuthorById?id=' + authorId,
        type: 'GET',
        dataType: 'json',
        success: function (author) {
            let message = "You are about to delete author '" + author.firstName + " " + author.lastName + "'. ";
            message += "If you proceed with this action, Application will permanently delete all books related to this author.";
            $("#delete-form-text").html(message);
            document.getElementById("form-delete-button").onclick = deleteAuthor;
            $("#form-cancel-button").attr("onclick", "changeView('authorList')");
        },
        error: function (author) {
            alert(author);
        }
    });
}

// call controller method to remove the selected author from the database
function deleteAuthor() {
    // extract id from heading
    let id = $("#page-heading").html();
    id = id.match(/\d+/);

    // call function to delete author
    $.ajax({
        url: 'http://bookstore.test/spa/authors/deleteAuthor?id=' + id,
        type: 'DELETE',
        dataType: 'json',
        success: function (response) {
            changeView("authorList");
        },
        error: function (response) {
            alert(response);
        }
    });
}

// fill table with JSON data
function fillTableAuthorList(JSON_Data) {
    let table = document.getElementById('table');

    // delete table header if any exists
    $("#table thead").remove();

    // create new table head
    let new_thead = document.createElement('thead');

    // add row to table head
    let tr = document.createElement('tr');
    tr.innerHTML = '<th scope="col">Authors</th><th scope="col" class="align-right">Books</th><th scope="col" class="align-right">Actions</th>';
    new_thead.appendChild(tr);

    // insert table head into table
    table.appendChild(new_thead);

    // delete all previous rows in the table body if any exist
    $("#table tbody").remove();

    // create new table body
    let new_tbody = document.createElement('tbody');

    // fill table body rows with JSON data
    JSON_Data.forEach(function (author) {
        let tr = document.createElement('tr');

        // add author name
        tr.innerHTML = '<th><img class="avatar-image" src="/Resources/Images/person-avatar-icon.png">'
            + '<a href="javascript:getBooksByAuthor(' + author.id + ', \'' + author.firstName + ' ' + author.lastName + '\')" class="author-link">' + author.firstName
            + " " + author.lastName + '</a></th>';

        // add author book count
        tr.innerHTML += "<td class='align-right'><div class='count-circle shadow-sm'>" + author.bookCount + "</div></td>";

        // add action button edit
        tr.innerHTML += '<td class="align-right"><form action="javascript:showEditAuthor(' + author.id + ')" method="post" class="form-button">'
            + '<input type="image" class="edit-button" name="Edit-Author-Button" src="/Resources/Images/edit.png" value="Submit" alt="edit button"/></form>'

            // add action button delete
            + '<form action="javascript:showConfirmDeleteAuthor(' + author.id + ')" method="post" class="form-button">'
            + '<input type="image" class="remove-button" name="Remove-Author-Button" src="/Resources/Images/delete.png" value="Submit" alt="remove button"/></form>';

        new_tbody.appendChild(tr);
    });

    // insert table body into table
    table.appendChild(new_tbody);
}