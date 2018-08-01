<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>
            File Sharing Site
        </title>
        
        <link rel="stylesheet" type="text/css" href="module_2_group.css" />
    </head>
    <body>
        <!--            idea for header came from https://www.w3schools.com/howto/howto_css_responsive_header.asp       -->
        <div class="header">
                <a href="#default" class="logo">File Sharing Site</a>
                <div class="header-right">
                  <a class="active" href="post_login.php">Home</a>
                  <a href="logout.php">Log Out</a>
                </div>
             </div>
        <div class="content">
        
<!--        form for signing in     -->
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <p>
                <label for="username_input">Username:</label>
                <input type="text" name="username" id="username_input" />
             </p>
             <p>
                <label for="password_input">Password:</label>
                <input type="text" name="password" id="password_input" />
             </p>
      
            <p>
                 <input type="Submit" name="button" value="Submit" />
            </p>
        </form>
        
        <?php
        session_start();
        //found the idea for this at https://stackoverflow.com/questions/42721005/php-checkin-if-username-and-password-are-correct-from-txt-file
            if(isset($_POST['button'])){
                if(isset($_POST['username']) && isset($_POST['password'])){
                    $user = $_POST['username'];
                    $pass = $_POST['password'];
                    $users_file = '/home/asantrach/users.txt';
                    $msg = "";
                    
                    $file = fopen($users_file, 'r');
                    while(!feof($file)){
                        
                        $line = fgets($file);
                        list($user_from_file, $pass_from_file) = explode(':', $line);
                        
                        if(trim($user_from_file) == $user && trim($pass_from_file) == $pass){
                            $msg = "Logged in";
                            $_SESSION['username'] = $user;
                            header("Location: post_login.php");
                            exit;
                            break;
                        }
                        elseif(trim($user_from_file) == $user && trim($pass_from_file) != $pass){
                            $msg = 'Wrong Password';
                            break;
                        }else {
                            $msg = 'Not a valid user';
                        }
                    }
                    
                    echo $msg;
                    
                    fclose($file);
                }
            }
        ?>
        </div> 
    </body>
    
</html>
