<footer class="footer">
  <div class="container">
    <span class="text-muted">&copy;2019 StarlimeWeb</span>
  </div>
</footer>



<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalTitle">Log in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="loginAlert"></div>
        <form>
          <input type="hidden" id="loginActive" name="loginActive" value="1">
          <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailSubtext" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group signupOnly">
            <label for="username">Username</label>
            <input name="username" type="text" class="form-control" id="username" aria-describedby="username" placeholder="UniqueUsername123">
            <small id="usernameSubtext" class="form-text text-muted">Enter a unique username!</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input name="password"type="password" class="form-control" id="password" placeholder="Password">
          </div>
         <!-- <div class="form-check">
            <input type="checkbox" class="form-check-input" id="formCheckbox">
            <label class="form-check-label" for="rememberMe" value="1">Remember Me</label>
          </div>
          <button type="submit" class="btn btn-info">Submit</button>-->
		</form>
      </div>
      <div class="modal-footer">
        <span class=""><a id="signupTag">Don't have an account?</a></span>
        <span class="blue"><a id="toggleLogin">Sign up!</a></span>
        <button type="button" class="btn btn-info" id="loginSignupButton">Log-in</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style>
  #loginAlert{
  	display:none;
  }
</style>

<script>
  $(".signupOnly").hide();
  $("#postSuccessful").hide();
  $("#postError").hide();
  $("#toggleLogin").click(function() {

  		if ($("#loginActive").val() == "1"){
          $(".signupOnly").show();
          $("#loginActive").val("0");
          $("#loginModalTitle").html("Sign Up");
          $("#loginSignupButton").html("Sign Up");
          $("#toggleLogin").html("Login");
          $("#signupTag").css("display", "none");

      	} else {
          $('.signupOnly').hide();
          $("#loginActive").val("1");
          $("#loginModalTitle").html("Log in");
          $("#loginSignupButton").html("Log in");
          $("#toggleLogin").html("Sign up");

    	}
  })

  	$("#loginSignupButton").click(function() {


      $.ajax({
      	type: "POST",
        url: "actions.php?action=loginSignup",
        data: "email=" + $("#email").val() + "&username=" + $("#username").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
        success: function(result) {
        	if (result == "1") {

            	window.location.assign("https://starlimeweb.com/NexxUs/");

            } else {
            	$("#loginAlert").html(result).show();
            }
        }
      })

    })


  	$(".toggleFollow").click(function() {
    	//alert($(this).attr("data-userId"));

      var id = $(this).attr("data-userId");

      $.ajax({
      	type: "POST",
        url: "actions.php?action=toggleFollow",
        data: "userId=" + id,
        success: function(result) {

          if(result == "1") {
          	$("a[data-userId='" + id + "']").html("Follow");
          } else if (result == "2") {
          	$("a[data-userId='" + id + "']").html("Unfollow");
          }
        }
      })
    //   let profilePage = '?page=profile';
    //  if(location.href = profilePage){
    //      window.location.reload();
    //  }
    })


    //postContent
    // makePostButton
    $("#makePostButton").click(function(){
    	var patt = new RegExp(/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)/g);

    	if(patt.test( $("#postContent").val()) == true){
    	    $("#postError").html("Not allowed to post tags!").show();
    	    return false;
    	};

      	$.ajax({
      	type: "POST",
        url: "actions.php?action=makePost",
        data: "postContent=" + $("#postContent").val(),
        success: function(result) {

         if (result == "1") {
         	$("#postSuccessful").show();
          $("#postError").hide();

         } else if (result != "") {

         	$("#postError").html(result).show();
			$("#postSuccessful").hide();
         }

        }
      })


    })

    $(".removePost").click(function(e){
            e.preventDefault();
            var postId = $(this).attr("data-postId");

            // FUTURE: put confirm delete in modal box
            var result = confirm("Are you sure you want to delete this post?");
            if (result) {
                //Logic to delete the item
                $.ajax({
                   type: "POST",
                    url: "actions.php?action=removePost",
                    data: {postId: postId},
                    success: function(data){
                        if(data == true){
                            location.reload();
                        }
                    }
                });
            }
            // If they hit cancel, we do not want to go through with this action
        });

  		var textMax = 200;
    	$('#textarea_feedback').html(textMax + ' characters remaining');

    	$('#postContent').keyup(function() {
            var textLength = $('#postContent').val().length;
            var textRemaining = textMax - textLength;

            $('#textarea_feedback').html(textRemaining + ' characters remaining');

            if( textLength == textMax ) {
                $("#textarea_feedback").css("color", "red");
            }else{
                $("#textarea_feedback").css("color", "black");
            }
        });



</script>


  </body>
</html>
