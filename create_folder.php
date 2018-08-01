<!DOCTYPE html>
    <html lang='en'>
        <head>
            <title>
                Create a Folder!
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
<!--       self submitting form for folders and getting folder name     -->
            <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                    <label for="folder_input">Folder name:</label> <input name="folder_name" type="text" id="folder_input" />
                </p>
                <p>
                    <input type="submit" name="new_folder" value="Create a Folder" />
                </p>
            </form>
            </div>
        </body>
    </html>
    
    <?php
    
        session_start();
//        check if someone is signed in 
            if(!(isset($_SESSION['username']))){
            header("Location: first_page.php");
            exit;
            }
        $username = $_SESSION['username'];
        
        if(isset($_GET['folder'])){
            $_SESSION['folder'] = $_GET['folder'];
        }
        $file_path = $_SESSION['folder'];
//        create folder and  send back or say failed
        if(isset($_POST['new_folder'])){
            $path = $file_path .'/'.$_POST['folder_name'];
            if(mkdir($path)){
                header("Location: post_login.php");
                exit;
            }else {
               echo "Creating a folder failed";
            }  
        }
    
    ?>
    