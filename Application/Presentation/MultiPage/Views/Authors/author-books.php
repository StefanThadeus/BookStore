<?php
/** @var array $data */
$author = $data['author'];
$bookList = $data['bookList'];
$baseURL = $data['baseURL'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - Author Book List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">
</head>
<body class="container align-left">

<h1 id="page-heading" class="heading">
    Book List by Author: <span class="author-name-color"><?php echo $author->getFirstName() . " " . $author->getLastName(); ?></span>
</h1>

<span>
    <table id="author-table" class="table vertical-center">
  <thead>
    <tr>
      <th scope="col">Books</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($bookList as $book) { ?>
      <tr><th><img class='avatar-image' src='/Resources/Images/book-icon.png'><a href='<?php echo $baseURL; ?>books/bookList' class='author-link'>
      <?php echo $book->getTitle() . " (" . $book->getYearOfRelease() . ")"; ?> </a></th></tr>
  <?php } ?>

  </tbody>
</table>
</span>

<form method="post" action="<?php echo $baseURL; ?>authors/authorList">
    <input type="submit" class="btn btn-primary button-margin" name="Add-Author-Button" value="Return"/>
</form>

</body>
</html>
