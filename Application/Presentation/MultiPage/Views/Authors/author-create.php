<?php
/** @var array $data */

// booleans to check whether to display error messages for previous input
$firstNameError = $data['firstNameError'];
$lastNameError = $data['lastNameError'];
$baseURL = $data['baseURL'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BookStore - Create Author</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/Resources/CSS/styles.css">
</head>
<body class="container align-left">

<h1 id="page-heading" class="heading">
    Author Create
    <hr>
</h1>

<form method="post" action="<?php echo $baseURL; ?>authors/createNewAuthor" class="shadow-sm p-4 mb-6 form-background">
    <div class="form-group">
        <label>First name</label>
        <input type="text" class="form-control" name="firstName" placeholder="Enter first name" value="">
    </div>

    <div class="error-message">
        <?php
        if ($firstNameError){
            echo "First name must contain between 1 and 100 characters!";
        }
        ?>
    </div>

    <div class="form-group">
        <label>Last name</label>
        <input type="text" class="form-control" name="lastName" placeholder="Enter last name">
    </div>

    <div class="error-message">
        <?php
        if ($lastNameError){
            echo "Last name must contain between 1 and 100 characters!";
        }
        ?>
    </div>

    <div class="align-right">
        <button type="submit" name="submit" value="Submit" class="btn btn-primary button-margin">Save</button>
    </div>
</form>

</body>
</html>
