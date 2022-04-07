<?php

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - SPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include custom JavaScript files -->
    <script src="/Resources/JavaScript/ViewFunctions.js"></script>
    <script src="/Resources/JavaScript/AuthorFunctions.js"></script>
    <script src="/Resources/JavaScript/BookFunctions.js"></script>

</head>
<body class="container align-left">

<h1 class="heading">
    <em>Single Page Application</em>
    <!-- Single Page App navigation button -->
    <button id="btn-navigation" class="btn btn-primary btn-navigation" onclick="changeListView()">Go to Book List
    </button>
    <hr>
</h1>

<h2 id="page-heading" class="heading"></h2>

<span id="tableSpan">
    <table id="table" class="table vertical-center">
        <thead>
        </thead>
        <tbody>
        </tbody>
    </table>

    <input id="add-button"  type="image" onclick="showCreateAuthor()" class="add-button" name="Add-Author-Button" src="/Resources/Images/plus.png"
           value="Submit" alt="add button"/>
</span>

<!-- EDIT FORM ***************************************************************************************************** -->
<div id="editForm" class="shadow-sm p-4 mb-6 form-background">
    <div class="form-group">
        <label for="input-one" id="label-one">Title</label>
        <input id="input-one" type="text" class="form-control" name="title" placeholder="Enter first name" value="">
    </div>

    <div id="error-one" class="error-message">
        Title must contain between 1 and 250 characters!
    </div>

    <div class="form-group">
        <label for="input-two" id="label-two">Year</label>
        <input id="input-two" type="text" class="form-control" name="year" placeholder="Enter last name" value="">
    </div>

    <div id="error-two" class="error-message">
        Year must be in range [-5000, 999999], and cannot be 0!
    </div>

    <div class="align-right">
        <button id="form-save-button" onclick="saveEditAuthor()" class="btn btn-primary button-margin">Save</button>
    </div>
</div>

<!-- DELETE FORM *************************************************************************************************** -->
<div id="confirmDeleteForm" class="shadow-sm p-4 mb-6 form-background">
    <div id="delete-form-text">
        You are about to delete an author.
    </div>

    <div class="align-right">
        <button id="form-delete-button" onclick="deleteAuthor()" type="submit" name="submit" value="Submit" class="btn btn-danger button-margin button-inline-form">Delete</button>
        <button id="form-cancel-button" onclick="changeView('authorList')" type="submit" name="submit" value="Submit" class="btn btn-outline-secondary button-margin button-inline-form">Cancel</button>
    </div>
</div>

</body>
</html>
