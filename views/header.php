<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon-->
    <link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- All other CSS -->
    <link rel="stylesheet" href="./styles.css">

    <title>NexxUs &middot;</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-info">
  <a class="navbar-brand" href="./index.php">NexxUs</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="?page=profile">Your Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=yourposts">Your Posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0 pull-xs-right">
      <?php if ($_SESSION['id']) { ?>

  		<a id="logoutBtn" class="btn btn-outline-light my-2 my-sm-0" href="?function=logout">Logout</a>

	  <?php } else { ?>
      <button class="btn btn-outline-light my-2 my-sm-0" data-toggle="modal" data-target="#loginmodal">Login/Signup</button>
      <?php } ?>
    </div>
  </div>
</nav>
