<?php
/** @var array $data */

// data comes from data parameter in the controllers view function
$authorsList = $data['authorList'];
$baseURL = $data['baseURL'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - Authors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">
</head>
<body class="container align-left">

<h1 id="page-heading" class="heading">
    Author List
</h1>

<span>
    <table id="author-table" class="table vertical-center">
  <thead>
    <tr>
      <th scope="col">Authors</th>
      <th scope="col" class="align-right">Books</th>
      <th scope="col" class="align-right">Actions</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($authorsList as $author) { ?>
      <tr>
      <th><img class='avatar-image' src='/Resources/Images/person-avatar-icon.png'><a
                  href="<?php echo $baseURL; ?>authors/booksByAuthor?id=<?php echo $author->getId(); ?>"
                  class="author-link"><?php echo $author->getFirstName() . " " . $author->getLastName(); ?></a></th>
      <td class='align-right'><div class="count-circle shadow-sm"><?php echo $author->getBookCount(); ?></div></td>
      <td class='align-right'>
          <form action="<?php echo $baseURL; ?>authors/editAuthor?id=<?php echo $author->getId(); ?>" method="post"
                class="form-button">
            <input type="image" class="edit-button" name="Edit-Author-Button"
                   src="/Resources/Images/edit.png" value="Submit" alt="edit button"/>
          </form>
          <form action="<?php echo $baseURL; ?>authors/confirmDeleteAuthor?id=<?php echo $author->getId(); ?>" method="post"
                class="form-button">
            <input type="image" class="remove-button" name="Remove-Author-Button"
                   src="/Resources/Images/delete.png" value="Submit" alt="remove button"/>
          </form>
      </td>
      </tr>
  <?php } ?>

  </tbody>
</table>
</span>

<form method="post" action="<?php echo $baseURL; ?>authors/createAuthor">
    <input type="image" class="add-button" name="Add-Author-Button" src="/Resources/Images/plus.png"
           value="Submit" alt="add button"/>
</form>

</body>
</html>
