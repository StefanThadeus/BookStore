// on load of the page, decide which view to present first
window.onload = function () {
    changeView("authorList");
    $("#editForm").hide();
    $("#confirmDeleteForm").hide();
    $("#add-button").show();
};

// Call either authorList or bookList on button click
function changeListView() {
    if ($("#btn-navigation").html() === "Go to Book List") {
        changeView("bookList");
    } else {
        changeView("authorList");
    }
}

// switch views based on input
function changeView(viewName) {
    if (viewName === "bookList") {
        $.ajax({
            url: 'http://bookstore.test/spa/books/ajaxGetBookList',
            type: 'GET',
            dataType: 'json',
            success: function (response) {

                fillTableBookList(response);
                $("#btn-navigation").html("Go to Author List");
                $("#page-heading").html("Book List");
                $("#tableSpan").show();
                $("#editForm").hide();
                $("#confirmDeleteForm").hide();
                $("#add-button").show();
                document.getElementById("add-button").onclick = showCreateBook;
            },
            error: function (response) {
                alert(response);
            }
        });
    } else if (viewName === "authorList") {
        $.ajax({
            url: 'http://bookstore.test/spa/authors/ajaxGetAuthorList',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                fillTableAuthorList(response);
                $("#btn-navigation").html("Go to Book List");
                $("#page-heading").html("Author List");
                $("#tableSpan").show();
                $("#editForm").hide();
                $("#confirmDeleteForm").hide();
                $("#add-button").show();
                document.getElementById("add-button").onclick = showCreateAuthor;
            },
            error: function (response) {
            }
        });
    }
}