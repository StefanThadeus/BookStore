<?php
/** @var array $data */

$toDelete = $data['book'];
$baseURL = $data['baseURL'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - Confirm Delete Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">
</head>
<body class="container align-left">

<h1 id="page-heading" class="heading">
    <img class="warning-icon" src="/Resources/Images/warning-icon.png"> Delete Book
    <hr>
</h1>

<div class="shadow-sm p-4 mb-6 form-background">
    <div>
        You are about to delete book
        '<?php echo $toDelete->getTitle() . " (" . $toDelete->getYearOfRelease() . ")"; ?>
        '. If you proceed with this action, Application will permanently delete this book.
    </div>

    <div class="align-right">
        <form class="button-inline-form" method="post" action="<?php echo $baseURL; ?>books/deleteBook?id=<?php echo $toDelete->getId(); ?>">
            <button type="submit" name="submit" value="Submit" class="btn btn-danger button-margin">Delete</button>
        </form>
        <form class="button-inline-form" method="post" action="<?php echo $baseURL; ?>books/bookList">
            <button type="submit" name="submit" value="Submit" class="btn btn-outline-secondary button-margin">Cancel</button>
        </form>
    </div>
</div>

</body>
</html>
