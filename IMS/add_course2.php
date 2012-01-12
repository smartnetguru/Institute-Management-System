<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Untitled</title>
	<link rel="stylesheet" type="text/css" media="screen" href="milk.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/chili.css" />

<script src="lib/jquery.js" type="text/javascript"></script>
<script src="jquery.validate.js" type="text/javascript"></script>

<style type="text/css">
	pre { text-align: left; }
</style>

<script id="demo" type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#signupform").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 2,
				remote: "users.php"
			},
			password: {
				required: true,
				minlength: 5
			},
			password_confirm: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true,
				remote: "emails.php"
			},
			dateformat: "required",
			terms: "required"
		},
		messages: {
			firstname: "Enter your firstname",
			lastname: "Enter your lastname",
			username: {
				required: "Enter a username",
				minlength: jQuery.format("Enter at least {0} characters"),
				remote: jQuery.format("{0} is already in use")
			},
			password: {
				required: "Provide a password",
				rangelength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			},
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address",
				remote: jQuery.format("{0} is already in use")
			},
			dateformat: "Choose your preferred dateformat",
			terms: " "
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.next() );
			else
				error.appendTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			alert("submitted!");
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});
	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});

});
</script>

</head>

<body>
	<div id="main">

<div id="content">

<div id="header">
  <div id="headerlogo"><img src="milk.png" alt="Remember The Milk" /></div>

</div>
<div style="clear: both;"><div></div></div>


<div class="content">
    <div id="signupbox">
       <div id="signuptab">
        <ul>
          <li id="signupcurrent"><a href=" ">Signup</a></li>
        </ul>
      </div>

  <div id="signupwrap">
      		<form id="signupform" autocomplete="off" method="get" action="">
	  		  <table>
	  		  <tr>
	  		  	<td class="label"><label id="lfirstname" for="firstname">First Name</label></td>
	  		  	<td class="field"><input id="firstname" name="firstname" type="text" value="" maxlength="100" /></td>
	  		  	<td class="status"></td>
	  		  </tr>

	  		  <tr>
	  			<td class="label"><label id="llastname" for="lastname">Last Name</label></td>
	  			<td class="field"><input id="lastname" name="lastname" type="text" value="" maxlength="100" /></td>
	  			<td class="status"></td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lusername" for="username">Username</label></td>
	  			<td class="field"><input id="username" name="username" type="text" value="" maxlength="50" /></td>

	  			<td class="status"></td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lpassword" for="password">Password</label></td>
	  			<td class="field"><input id="password" name="password" type="password" maxlength="50" value="" /></td>
	  			<td class="status"></td>
	  		  </tr>
	  		  <tr>

	  			<td class="label"><label id="lpassword_confirm" for="password_confirm">Confirm Password</label></td>
	  			<td class="field"><input id="password_confirm" name="password_confirm" type="password" maxlength="50" value="" /></td>
	  			<td class="status"></td>
	  		  </tr>
	  		  <tr>
	  			<td class="label"><label id="lemail" for="email">Email Address</label></td>
	  			<td class="field"><input id="email" name="email" type="text" value="" maxlength="150" /></td>
	  			<td class="status"></td>

	  		  </tr>
              	  		  <tr>
	  			<td class="label"><label>Which Looks Right</label></td>
	  			<td class="field" colspan="2" style="vertical-align: top; padding-top: 2px;">
	  			<table>
	  			<tbody>

	  			<tr>
	  				<td style="padding-right: 5px;">

		  				<input id="dateformat_eu" name="dateformat" type="radio" value="0" />
			            <label id="ldateformat_eu" for="dateformat_eu">14/02/07</label>
	  				</td>
	  				<td style="padding-left: 5px;">
		  				<input id="dateformat_am" name="dateformat" type="radio" value="1"  />
			            <label id="ldateformat_am" for="dateformat_am">02/14/07</label>
	  				</td>
	  				<td>

	  				</td>
	  			</tr>
	  			</tbody>
	  			</table>
	  			</td>
	  		  </tr>

	  		  <tr>
	  			<td class="label">&nbsp;</td>

	  			<td class="field" colspan="2">
		  			<div id="termswrap">
			  			<input id="terms" type="checkbox" name="terms" />
			            <label id="lterms" for="terms">I have read and accept the Terms of Use.</label>
		            </div> <!-- /termswrap -->
	  			</td>
	  		  </tr>
	  		  <tr>

	  			<td class="label"><label id="lsignupsubmit" for="signupsubmit">Signup</label></td>
	  			<td class="field" colspan="2">
	            <input id="signupsubmit" name="signup" type="submit" value="Signup" />
	  			</td>
	  		  </tr>

	  		  </table>
          </form>
      </div>
</div>
</div>

</div>
</div>


</body>
</html>
