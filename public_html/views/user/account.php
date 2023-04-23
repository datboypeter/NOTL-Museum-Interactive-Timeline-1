<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-DW5cX/mKzsRbfLb5jb5BVZXOj/Qbsxw1dTXZrxbh8HqpW0bK9g40abDewMvOQ2LWxjN0pm/eSHdncHrZk8Wakg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Custom CSS -->
	<link rel="stylesheet" href="https://badger-timeline.infinityfreeapp.com/public_html/assets/CSS/form.css">
</head>
<?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        ob_start();
        include '/home/vol4_4/epizy.com/epiz_33561013/htdocs/public_html/includes/header.php';
        ob_end_flush();
?>

  <?php
        // handle login form submission
        if (!$guest) 
        {
            
            // session_start();
            $user_id = $_SESSION["user_id"];
            session_write_close();
            $url = "https://badger-timeline.infinityfreeapp.com/public_html";
            echo "<script>window.location.replace('$url');</script>";
            exit;

        }
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            require_once '../../controllers/UserController.php';
            $controller = new UserController();
            if(isset($_POST['login']))
            {
                $result = $controller->login($_POST['email'], $_POST['password']);

                print("back?");
                if ($result == true) {
                $url = "https://badger-timeline.infinityfreeapp.com/public_html";
                echo "<script>window.location.replace('$url');</script>";
                exit;

                echo '<p>login successful! You can now log in.</p>';
                } else {
                echo '<p>login failed. Please try again.</p>';
                }
            }
            if(isset($_POST['signup']))
            {
                $result = $controller->register($_POST['username'], $_POST['email'], $_POST['password'],$_POST['confirm_password']);
                
                // print("back?");
                // if ($result === true) {
                //     echo '<p>Registration successful! You can now log in.</p>';
                // } else {
                //     echo '<p>Registration failed. Please try again.</p>';
                // }
            }
        }
    ?>
<body style="overflow-x:hidden;">
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 custom-login">
            <h4 class="logtext">Login</h4>



            <form method="POST" class="logform">
                <div class="form-group">
                    <input type="email" placeholder="Email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="" required> <i class="fas fa-envelope"></i>
                </div>   
                <div class="form-group">
                        <input type="password" placeholder="Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="" required>
                </div>
                <div class="form-group">
                        <input  name = "login" type="submit" class="btn btn-secondary" value="Sign in">
                </div>
                <p>Or log in with:</p>
                <a href="/Images/google-icon.png" class="mx-3"><i class="fab fa-facebook-f fa-2x"></i></a>
                <a href="#" class="mx-3"><i class="fab fa-google fa-2x"></i></a>
                <a href="#" class="mx-3"><i class="fab fa-twitter fa-2x"></i></a>
                <p>Forgot Password? <a href="https://badger-timeline.infinityfreeapp.com/public_html/views/user/forgot_password">Verify email and reset your password.</a><p>
            </form>

          </div>
          <div class="col-lg-6 custom-signup">  
            <h4>Sign Up</h4>
            <form method="POST" class = "signform">
              <div class="form-group">
                <input type="text" name="username" class="form-control" value="" placeholder="Username" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
              </div>
              <div class="form-group">
                <input type="password" name="password" id = "password" class="form-control" id="inputPassword" placeholder="Password">
                <span class="invalid-feedback"><?php echo $password_err; ?></span><span id = "restrictions"></span>
              </div>
              <div class="form-group">
                <input type="password" name="confirm_password" id = "confirm_password" class="form-control" placeholder="Re-type Password">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span><span id = "equivalence"></span>
              </div>
              <button type="submit" id = "submitButton" name = "signup" class="btn btn-secondary">Sign up</button>
            </form>
       </div>
      </div>
    </div>
    <script>
    const password = document.getElementById("password");
    const restrictions = document.getElementById("restrictions");
    var submitButton = document.getElementById("submitButton");
    var upperCount = 0;
    var hasValidLength = false;
    var hasSpecialChar = false;
    var hasAlphanumeric = false;

    const confirmPasswordInput = document.getElementById("confirm_password");
    submitButton.disabled = true;
    password.addEventListener("input", function() {
    upperCount = 0;
    let str = password.value;
    hasSpecialChar = str.match(/[^\w\s]/) !== null;
    for(let i = 0; i < str.length; i++) {
        if(/[A-Za-z0-9]/.test(str[i])) {
        hasAlphanumeric = true;
        if(/[A-Z]/.test(str[i])) {
            upperCount++;
            // console.log(upperCount);
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
    let confirmPassword = confirmPasswordInput.value;

    if (upperCount>=2 && hasSpecialChar && hasAlphanumeric && hasValidLength && str=== confirmPassword) 
    {
        // message.innerHTML = "Password is valid";
        submitButton.disabled = false;
    } 

    });

    const message = document.getElementById("equivalence");

    confirmPasswordInput.addEventListener("input", function() {
    let password_val = password.value;
    let confirmPassword = confirmPasswordInput.value;

    if(confirmPassword === password_val) {
        message.innerHTML = "Passwords match.";
        if (upperCount>=2 && hasSpecialChar && hasAlphanumeric && hasValidLength) 
    {
        // message.innerHTML = "Password is valid";
        submitButton.disabled = false;
    } 
    } else {
        message.innerHTML = "Passwords do not match.";
    }


    });
    </script>
	<!-- add bootstrap js files -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNSbHZN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
include '/home/vol4_4/epizy.com/epiz_33561013/htdocs/public_html/includes/footer.php';
?>
</body>
</html>
