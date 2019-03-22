<?php

    include("functions.php");
    include("views/header.php");

	  if ($_GET['page'] == 'profile'){
    	include("views/profile.php");

    } else if ($_GET['page'] == 'publicprofiles'){
    	include("views/publicprofiles.php");

    } else if ($_GET['page'] == 'yourposts'){
    	include("views/yourposts.php");

    } else if ($_GET['page'] == 'search'){
    	include("views/search.php");

    } else {
    	include("views/home.php");
    }
    include("views/footer.php");

?>
