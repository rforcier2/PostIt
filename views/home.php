<div class="container mainCont">
	<!--<h1 class="display-4 mt-3">Home</h1>-->
    <div class="row">
      <div class="col-md-8 left-side-div">
         <?php displayLoginMessage();?>
        <h2>Recent Public Posts</h2>

        <?php displayPosts('public'); ?>
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
