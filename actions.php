<?php

	include("functions.php");

	if ($_GET['action'] == "loginSignup") {
      $error = "";

      if( !$_POST['email'] ){
      		$error = "An email is required ";
      } else if ( !$_POST['password'] ) {
        	$error = "A password is required ";
      } else if ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false ) {
          $error = "That is not a valid email ";
	    } else if ( !$_POST['username'] && $_POST['loginActive'] == "0" ){
	      $error = "A username is required ";
	    }

      if ($error != "") {

        echo $error;
      	exit();

      }

      if ($_POST['loginActive'] == "0") {

        $emailQuery = "SELECT * FROM users WHERE email = '". mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
        $usernameQuery = "SELECT * FROM users WHERE username = '".mysqli_real_escape_string($link, $_POST['username'])."' LIMIT 1";
        $emailResult = mysqli_query($link, $emailQuery) or die(mysqli_error($link));
        $usernameResult = mysqli_query($link, $usernameQuery) or die(mysqli_error($link));

        $rowcntEmail = mysqli_num_rows($emailResult);
        $rowCountUsername = mysqli_num_rows($usernameResult);

        if ($rowcntEmail > 0) {
            $error = "Sorry! That email is already taken.";
        }
        if($rowCountUsername > 0){
            $error = "Sorry! That username is already taken.";
        }

        else {
      	$query = "INSERT INTO users (`email`,`username`, `password`) VALUES ('". mysqli_real_escape_string($link, $_POST['email'])."', '". mysqli_real_escape_string($link, $_POST['username'])."', '". mysqli_real_escape_string($link, $_POST['password'])."')";

        if (mysqli_query($link, $query)) {
          $_SESSION['id'] = mysqli_insert_id($link);
          $query = "UPDATE users SET password = '".md5(md5($_SESSION['id']).$_POST['password']) ."' WHERE id = ".$_SESSION['id']." LIMIT 1";
          mysqli_query($link, $query);
        	echo 1;

        } else {
        	$error = "could not create user";
        }

      	}
     } else {
      	$query = "SELECT * FROM users WHERE email = '". mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        	if ($row['password'] == md5(md5($row['id']).$_POST['password'])){
            		echo 1;
				$_SESSION['id'] = $row['id'];
            } else {
            		$error = "could not find user name / passsword " ;
            }
      }

      if ($error != "") {
      	echo $error;
        exit();
      }

    }


	if ($_GET['action'] == 'toggleFollow') {
    	$query = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ".mysqli_real_escape_string($link, $_POST['userId'])."  LIMIT 5";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
          	$row = mysqli_fetch_assoc($result);
          	mysqli_query($link, "DELETE FROM isFollowing WHERE id=".mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
          	echo "1";
        }	else {
          	mysqli_query($link, "INSERT INTO isFollowing (follower, isFollowing) VALUES(".mysqli_real_escape_string($link, $_SESSION['id']).", ".mysqli_real_escape_string($link, $_POST['userId']).")");
          	echo "2";
      }

    }

	if ($_GET['action'] == "makePost") {

     	if (!$_POST['postContent']) {
       		echo "Your post cannot be empty";
         } else if (strlen($_POST['postContent']) > 200) {
        	echo "Sorry, this post is too long!";
        } else {
        	mysqli_query($link, "INSERT INTO posts (`post`, `userid`, `datetime`) VALUES('".mysqli_real_escape_string($link, $_POST['postContent'])."', ".mysqli_real_escape_string($link, $_SESSION['id']).", NOW())");
          echo "1";
        }

    }

 if($_GET["action"] == "removePost"){
        $query = "DELETE FROM posts WHERE id = ".mysqli_real_escape_string($link, $_POST["postId"])." LIMIT 1";
        mysqli_query($link, $query);
        echo true;
    }



?>
