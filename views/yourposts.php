<div class="container mainCont">
	<!--<h1 class="display-4 mt-3">Home</h1>-->
    <div class="row">
      <div class="col-md-8 left-side-div">
        <h2>Your Posts</h2>

        <?php displayPosts('yourposts'); ?>
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
