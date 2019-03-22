<div class="container mainCont">
	<!--<h1 class="display-4 mt-3">Home</h1>-->
    <div class="row">
      <div class="col-md-8 left-side-div">

        <?php if ($_GET['userid']) { ?>

        <?php displayPosts($_GET['userid']); ?>

        <?php } else {	?>
        <h2>Public Profiles:</h2>
        <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">User Email</th>
          </tr>
        </thead>
        <tbody>
          <?php displayProfiles(); ?>
        </tbody>
      </table>


        <?php } ?>
      </div>

      <div class="col-md-4 right-side-div">
        <h2>Search or Post</h2>
        <?php displaySearch(); ?>
        <br>
        <hr>
        <?php displayPostBox(); ?>
      </div>
    </div>

</div>
