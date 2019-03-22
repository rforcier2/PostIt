<div class="container mainCont">
	<!--<h1 class="display-4 mt-3">Home</h1>-->
    <div class="row">

      <div class="col-md-8 left-side-div">
        <h2>Search Results: </h2>
        <?php displayPosts('search'); ?>
      </div>

      <div class="col-md-4">
        <h2>Search or Post</h2>
        <?php displaySearch(); ?>
        <br>
        <hr>
        <?php displayPostBox(); ?>
      </div>
    </div>

</div>
