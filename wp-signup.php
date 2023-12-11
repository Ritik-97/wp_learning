<?php
/* Template Name: Custom Registrations Page */
get_header();
if($_POST){
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$ConfirmPassword=$_POST['confirmpassword'];
$error=array();
    // if(strpos($username, '')!== FALSE){
    //     $error['username_space'] ="Username has space";
    // }

    if(empty($username)){
        $error['username_empty'] ="you must have to type username";
    }
    if(username_exists($username)){
        $error['username_exists'] ="Username already exists!! Try with different one";
    }
    if(!is_email($email)){
        $error['email_valid'] ="Please enter a valid Email";
    }
    if(strcmp($password , $ConfirmPassword)!==0){
        $error['password'] ="Password didn't match";
    }

    // print_r($error);
    foreach ($error as $errors) {
        echo $errors;
        die();
        # code...
    }


    if(count($error)==0){

        wp_create_user($username,$password, $email);
        echo "User Created Sucessfully!!!!";

    }



}

?>

<div class= "form-contaner" style="display: grid;">
    <form method='post'>
        
        <label> Enter Your Name</label>
        <div>
        <input type="text" id="username" name="username" placeholder="Enter here"></input>
        </div>

        <label> Enter Your Name</label>
        <div>
        <input type="text" id="username" name="username" placeholder="Enter here"></input>
        </div>

        <label> Enter Username/Email</label>
        <div>
        <input type="text" id="email" name="email" placeholder="Enter Username/Email"></input>
        </div>

        <label> Enter Password</label>
        <div>
        <input type="password" id="password" name="password" placeholder="Enter here"></input>
        </div>

        <label> Confirm Password</label>
        <div>
        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Enter here"></input>
        </div>
    

    
        <button type="submit" style ="margin-top:10px;" name="btn_submit"> Sign in </button>
    
    </form>
    <h4><a href= <?php echo home_url(). '/login'  ?> >Login Now</a></h4>

</div>
<?php
get_footer();
?>