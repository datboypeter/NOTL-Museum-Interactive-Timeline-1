<?php include '/home/vol4_4/epizy.com/epiz_33561013/htdocs/public_html/includes/header.php'; ?>


        <?php
        
        require_once '../../controllers/UserController.php';
        $controller = new UserController();
        $user_info = $controller->userProfileEdit();
        if ($guest) {
        $url = "https://badger-timeline.infinityfreeapp.com/public_html";
        echo "<script>window.location.replace('$url');</script>";
        exit;
        }
        $username = $user_info['username'];
        $email= $user_info['email'];
        $user_id= $user_info['user_id'];
        // handle form submission

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
           
            if (isset($_POST['update'])) 
            {
                require_once '../../controllers/UserController.php';
                $controller = new UserController();
                $check = $controller->updateUserProfile();
                if($check)
                {
                    header('Location: /public_html/');
                }
            }

            // Check if the cancel button was clicked
            if (isset($_POST['cancel'])) {
            // Redirect to the profile page
            header('Location: /public_html/views/user/profile');
            exit;
            }

           
        }
        ?>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
 body{
     font: 14px sans-serif;
     background: url('https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/Images/paper.jpg?raw=true') center center fixed;
     background-size: cover;
     position: relative;
}
 body::before {
     content: "";
     display: block;
     position: fixed;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     backdrop-filter: blur(5px);
    /* Adjust blur strength as needed */
     opacity: 0.5;
    /* Adjust opacity as needed */
     background-color: #000000;
    /* Adjust background color as needed */
     z-index: -1;
    /* Set z-index to ensure the pseudo-element is positioned below other elements */
}
 .wrapper{
     width: 360px;
     padding: 20px;
}
 .hidden {
    display:none;
}
/* Custom CSS for divs */
 .avatar-img {
     max-width: 80px;
     max-height: 80px;
     cursor: pointer;
     transition: transform 0.3s ease-in-out;
}
 .avatar-img:hover {
     transform: scale(1.1);
}
 .center-div {
     display: flex;
     justify-content: center;
     align-items: center;
     height: 100vh;
}
 .img-preview {
     width: 100px;
     height: 100px;
     object-fit: cover;
     border-radius: 50%;
     margin-top: 10px;
}
 .form-container {
     min-width: 30vw;
     margin: 0 auto;
     padding: 20px;
     background-color: #f8f9fa;
     border-radius: 5px;
     box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
     max-width: 35vw;
}
 .custom-file-input {
     cursor: pointer;
}
 .form-group+.form-group {
     margin-top: 10px;
}
 .or-text-container {
     text-align: center;
     margin-top: 10px;
     margin-bottom: 10px;
}
 .or-text {
     display: inline-block;
     background-color: white;
     padding: 0 10px;
}
 .avatar-img {
     width: 100px;
     height: 100px;
     object-fit: cover;
     border-radius: 50%;
}
 #edit.container {
     justify-content:center;
}
    </style>


    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>

<body>
	<div class="container mt-5">
		<div class="form-container">
			<h3 class="text-center">Profile </h3>

			<div id="edit" class="hidden container">
				<form method="post" autocomplete="off">
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" class="form-control <?php echo !empty(
          $username_err
      )
          ? "is-invalid"
          : ""; ?>" value="<?php echo $username; ?>" placeholder="Enter username" required>
						<span class="invalid-feedback"><?php echo $username_err; ?></span>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control <?php echo !empty(
          $email_err
      )
          ? "is-invalid"
          : ""; ?>" value="<?php echo $email; ?>" placeholder="Enter email" required>
						<span class="invalid-feedback"><?php echo $email_err; ?></span>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="new_password" id="password" class="form-control <?php echo !empty(
          $password_err
      )
          ? "is-invalid"
          : ""; ?>" value="" required>
						<span class="invalid-feedback"><?php echo $password_err; ?></span><span id="restrictions"></span>
					</div>
					<div class="form-group">
						<input id="submitButton" type="submit" name="update" class="btn btn-primary" value="Update">
						<input type="reset" class="btn btn-secondary ml-2" value="Reset">
						<button class="btn btn-secondary" onclick="toggleEdit()">Cancel</button>
					</div>
				</form>
			</div>

			<div class="profile-editinfo text-center">
				<div id="read_only">
					<p>The following are your credentials.</p>
					<hr>
					<p>Name: <?php echo $username; ?></p> <br> <br>
					<p>Email: <?php echo $email; ?></p> <br> <br>
					<button class="btn btn-secondary btn-sm" onclick="toggleEdit()">Edit</button>
				</div>
			</div>
		</div>
	</div>
    

        <div class="container mt-5">
        	<div class="form-container">
        		<h3 class="text-center">Edit Profile Picture</h3>
        		<form>
        			<div class="form-group text-center">
        				<label for="profilePicture">Profile Picture</label>
        				<br>
        				<img id="imgPreview" src="#" alt="Profile Picture Preview" class="img-thumbnail img-preview mt-3">
        				<hr>
        				<div class="custom-file mb-3">
        					<input type="file" class="custom-file-input" id="profilePicture" onchange="readURL(this)">
        					<label class="custom-file-label" for="profilePicture">Choose File</label>
        				</div>
        			</div>
        			<div class="or-text-container">
        				<span class="or-text">OR</span>
        			</div>
        			<br>
        			<div class="form-group text-center">
        				<label for="avatar">Avatar</label>
        				<br>
        				<img src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/avatar2.jpg?raw=true" alt="Avatar 1" class="avatar-img rounded-circle mr-2">
        				<img src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/Images/ShippingA.jpg?raw=true" alt="Avatar 2" class="avatar-img rounded-circle mr-2">
        				<img src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/avatar1.jpg?raw=true" alt="Avatar 3" class="avatar-img rounded-circle">
        			</div>
        			<div class="form-group text-center">
        				<button type="submit" class="btn btn-secondary btn-sm">Save</button>
        			</div>
        		</form>
        	</div>
        </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
<script>
var user_id = <?php echo json_encode($user_id); ?>;
var profile = document.querySelector("#imgPreview");
if(user_id%3 == 0)
{
   profile.src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/avatar2.jpg?raw=true"; 
}
else if(user_id%3 == 1)
{
    profile.src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/avatar1.jpg?raw=true";
}
else
{
    profile.src="https://github.com/sowmyamovva/NOTL-Museum-Interactive-Timeline/blob/5b91dbca5c8246668075e686183b99a3e208144a/Images/ShippingA.jpg?raw=true";
}
const password = document.getElementById("password");
const restrictions = document.getElementById("restrictions");
var submitButton = document.getElementById("submitButton");
var upperCount = 0;
var hasValidLength = false;
var hasSpecialChar = false;
var hasAlphanumeric = false;

submitButton.disabled = true;
password.addEventListener("input", function() {
  let str = password.value;
  hasSpecialChar = str.match(/[^\w\s]/) !== null;
  for(let i = 0; i < str.length; i++) {
    if(/[A-Za-z0-9]/.test(str[i])) {
      hasAlphanumeric = true;
      if(/[A-Z]/.test(str[i])) {
        upperCount++;
      }
    }
  }

  hasValidLength = str.length >= 8;

  const alphanumericStatus = hasAlphanumeric ? "✔" : "❌";
  const lengthStatus = hasValidLength ? "✔" : "❌";
  const uppercaseStatus = upperCount >= 2 ? "✔" : "❌";
  const specialCharacterStatus = hasSpecialChar ? "✔" : "❌";

  const restrictionText = `Alphanumeric characters only: ${alphanumericStatus}<br>
                           Has a special character: ${specialCharacterStatus}<br>
                           Minimum length of 8 characters: ${lengthStatus}<br>
                           Minimum of 2 uppercase letters: ${uppercaseStatus}`;
  restrictions.innerHTML = restrictionText;

   if (upperCount>=2 && hasSpecialChar && hasAlphanumeric && hasValidLength) 
   {
    // message.innerHTML = "Password is valid";
    submitButton.disabled = false;
  } 

});

function toggleEdit() {
    // Get all the form fields
    var read_section = document.querySelector('#read_only');
    var edit_section = document.querySelector('#edit');
    // Disable or enable each form field depending on the current state
    read_section.classList.toggle("hidden");
    edit_section.classList.toggle("hidden");
  }
</script>
</html>