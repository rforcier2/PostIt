<?php
	session_start();
  
    $db_link = 'DB_LINK';
    $my_user = 'USERNAME';
    $my_pass = 'PASSWORD';
    $db_name = 'DB_NAME';

    $link = mysqli_connect($db_link, $my_user, $my_pass, $db_name);

  	if(mysqli_connect_errno()) {
      	print_r(mysqli_connect_error());
        	exit();
      }

  	if ($_GET['function'] == 'logout'){
      	session_unset();
      }


  	// TIMING OF POSTS FUNCTION
  	// Tells how long a go something was posted.
  		function time_since($since) {
              $chunks = array(
                  array(60 * 60 * 24 * 365 , 'year'),
                  array(60 * 60 * 24 * 30 , 'month'),
                  array(60 * 60 * 24 * 7, 'week'),
                  array(60 * 60 * 24 , 'day'),
                  array(60 * 60 , 'hour'),
                  array(60 , 'min'),
                  array(1 , 'sec')
              );

              for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                  $seconds = $chunks[$i][0];
                  $name = $chunks[$i][1];
                  if (($count = floor($since / $seconds)) != 0) {
                      break;
                  }
              }

          $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
          return $print;
          }


  	//Displays posts from users.
  	//
  	function displayPosts($type) {

        global $link;

        if ($type == 'public') {
        	$whereClause = "";

        } else if ($type == 'isFollowing'){
          if($type == 'isFollowing' && !$_SESSION['id']){
              echo
              '<div class="alert alert-info lead text-center mx-4">
                  By default, you will see the most recent 10 public posts.
              </div>';
          }
          $query = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id']);
          $result = mysqli_query($link, $query);
          $whereClause = "";
          if($result){
          if(mysqli_num_rows($result) < 1){
              echo
              '<div class="alert alert-info lead text-center mx-4">
                  By default, you will see the most recent 10 public posts.
                  <br>
                  Time to start following!
              </div>';
              }

          while ($row = mysqli_fetch_assoc($result)) {

            if ($whereClause == "") $whereClause = "WHERE";
            else $whereClause.= " OR";
            $whereClause .= " userid =".$row['isFollowing'];
          }

          }

        } else if ($type == 'yourposts') {
        	$whereClause = "WHERE userid =".mysqli_real_escape_string($link, $_SESSION['id']);


        } else if ($type == 'search') {
          echo '<div class="alert alert-light"> <h5>Displaying search results for "'.mysqli_real_escape_string($link, $_GET['s']).'"</h5></div>';
        	$whereClause = "WHERE post LIKE '%".mysqli_real_escape_string($link, $_GET['s'])."%'";


        } else if (is_numeric($type)) {

          	$userQuery = "SELECT * FROM users WHERE id =".mysqli_real_escape_string($link, $type)." LIMIT 1";
          	$userQueryResult = mysqli_query($link, $userQuery);
            	$user = mysqli_fetch_assoc($userQueryResult);

          echo "<h4 class='text-muted'>".mysqli_real_escape_string($link, $user['username'])."'s Posts: </h4>";

        	$whereClause = "WHERE userid =".mysqli_real_escape_string($link, $type);

        }



        $query = "SELECT * FROM posts ".$whereClause." ORDER BY `datetime` DESC LIMIT 10" or die (mysqli_error($link));
        $result = mysqli_query($link, $query);


        if(!$result || $result === 0) {
        	echo
        	"<div class='text-center alert alert-light mt-5'>
        	   <h4>You aren't logged in!</h4>

        	   <h5>You can make an account or login
        	     <a class='blue' style='color:teal!important' data-toggle='modal' data-target='#loginmodal'>
        	     here
        	     </a>
        	   </h5>

        	</div>";

        }
        if($result && mysqli_num_rows($result) < 1){
          echo
        	"<div class='text-center alert alert-light mt-5'>
        	   <h4>No posts to show yet.</h4>
        	</div>";

        }else {

          if($result){
            	while($row = mysqli_fetch_assoc($result)) {

                $userQuery = "SELECT * FROM users WHERE id =".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);

               echo
               "<div class='mb-3 pb-3 post'>
                 <p class='lead ml-3 my-2'>
                  <a href='?page=publicprofiles&userid=".$user['id']."'>".$user['username']."</a>
                    <span class='time'> posted ".time_since(time() - strtotime($row['datetime']))." ago</span>:
                  </p>";

                echo "<div class='px-2 py-2 mx-3' style='width:auto; font-family:Verdana;'>".$row['post']."</div>";

                if(isset($_SESSION["id"])){
                          if($row["userid"] == $_SESSION["id"]){
                              echo "<div><p class='ml-3 my-2'><a style='color:red' class='removePost' data-postId='".$row["id"]."' href='#'>Remove Post</a></div>";
                } else {

                echo"<div><div class='blue ml-3 my-3'><a id='toggleFollow' class='toggleFollow' data-userId='".$row['userid']."'>";

                $isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ".mysqli_real_escape_string($link, $row['userid'])."  LIMIT 1";

              $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);

              if (mysqli_num_rows($isFollowingQueryResult) > 0) {
                	echo "Unfollow";
              } else {
              	echo "Follow";
              }
                 echo "</a></div></div>";

                          }
              }echo "</div>";
            }//echo "</div>";
          }

      }
      }

  	// Search box function

  	function displaySearch(){

        echo '<form class="form-inline">
                <div class="form-group">
                	<input type="hidden" name="page" value="search">
                  <input type="text" name="s" class="form-control" id="search" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-info ml-1">Search Posts</button>
              </form>';

      }

  	// Post Box if user is Logged in only

  	function displayPostBox(){

          if ($_SESSION['id'] > 0) {

              echo '<div id="postSuccessful" class="alert alert-success"> You posted to the board successfully!</div>
              	<div id="postError" class="alert alert-danger"></div>
              	<div class="form">
                    <div class="form-group">
                      <textarea type="text" class="form-control mt-2" id="postContent" placeholder="What\'s on your mind?" maxlength="200"></textarea><div id="textarea_feedback"></div>
                    </div>
                    <button id="makePostButton" class="btn btn-info ml-1">Post</button>
                  </div>';
          }

      }


  	function displayProfiles() {

        global $link;
        $position = 1;
      	$query = "SELECT * FROM users LIMIT 10";
        	$result = mysqli_query($link, $query);
        	while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
              <th scope="count">'.$position.'</th>
              <td><a href="?page=publicprofiles&userid='.$row['id'].'">'.$row['username'].'</a></td>
            </tr>';
            $position++;
      }
      }

      function displayLoginMessage(){
          global $link;
          $id = $_SESSION['id'];
          $userQuery = "SELECT * FROM users WHERE id =".mysqli_real_escape_string($link, $id)." LIMIT 1" or die (mysqli_error($link));
          	$userQueryResult = mysqli_query($link, $userQuery);
          	if($userQueryResult){
            	    $user = mysqli_fetch_assoc($userQueryResult);
          	}
          if( isset($_SESSION['id'])){
              echo
              '<div class="text-center alert alert-light alert-dismissible fade show mx-2">
                  <h4>Welcome back '.$user['username'].'!</h4>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
          }
          else {
              echo
              '<div class="alert alert-info mx-2 text-center">
                  <h4>Welcome to NexxUs!</h4>
              </div>';
          }

      }

  ?>
