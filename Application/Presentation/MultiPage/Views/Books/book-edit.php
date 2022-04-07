<?php
/** @var array $data */
// data comes from data parameter in the controllers view function
$book = $data['book'];

// booleans to check whether to display error messages for previous input
$titleError = $data['titleError'];
$yearError = $data['yearError'];
$baseURL = $data['baseURL'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">
</head>
<body class="container align-left">

<h1 id="page-heading" class="heading">
    Book Edit (<?php echo $book->getId(); ?>)
    <hr>
</h1>

<form method="post" action="<?php echo $baseURL; ?>books/updateBook?id=<?php echo $book->getId(); ?>" class="shadow-sm p-4 mb-6 form-background">
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" placeholder="Enter first name" value="<?php echo $book->getTitle(); ?>">
    </div>

    <div class="error-message">
        <?php
        if ($titleError){
            echo "Title must contain between 1 and 250 characters!";
        }
        ?>
    </div>

    <div class="form-group">
        <label>Year</label>
        <input type="text" class="form-control" name="year" placeholder="Enter last name" value="<?php echo $book->getYearOfRelease(); ?>">
    </div>

    <div class="error-message">
        <?php
        if ($yearError){
            echo "Year must be in range [-5000, 999999], and cannot be 0!";
        }
        ?>
    </div>

    <div class="align-right">
        <button type="submit" name="submit" value="Submit" class="btn btn-primary button-margin">Save</button>
    </div>
</form>

</body>
</html>