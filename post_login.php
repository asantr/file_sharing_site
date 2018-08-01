<!DOCTYPE html>
    <html lang='en'>
        <head>
            <title>
                File Sharing Site
            </title>
             
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
            
            <link rel="stylesheet" type="text/css" href="module_2_group.css"/>
           <div class="content">

            <div>
                <h1>Your files:
                </h1>
                <ul>
                    <?php
                    ob_start();
                        session_start();
                        if(!(isset($_SESSION['username']))){
                            header("Location: first_page.php");
                            exit;
                        }
                        $username = $_SESSION['username'];
                        
                        // idea from https://teamtreehouse.com/community/ul-php-foreachflavors-as-flavor-liphp-echo-flavor-li-php-ul
                        $file_path = sprintf("/home/asantrach/uploads/%s", $username);
                        $files = array_slice(scandir($file_path), 2);
                        foreach($files as $file){
                            if(!(is_dir($file_path.'/'.$file))){
                    ?>
                        <li>
                            <a class="files" href="<?php echo sprintf("open_file.php?file_to_open=%s", $file)?>" > <?php echo $file ?> </a>
                            <a class="del" href="<?php echo sprintf("delete_file.php?file_to_delete=%s", $file)?>" >[x]</a>
                        </li>
                    <?php } else{ ?>
                        <li>
                            <a class="folder" href="<?php echo sprintf("open_folder.php?folder_to_open=%s", $file)?>" > <?php echo $file ?> </a>
                            <a class="del" href="<?php echo sprintf("delete_folder.php?folder_to_delete=%s", $file)?>" >[x]</a>
                        </li>
                     <?php }}?>
                </ul>
            </div>
            <div class="up">
                <form class="up" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <p>
                        <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                        <label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Upload File" />
                    </p>
                </form>
                
            </div>
            
            
            <form class="fld" enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p class="new_folder">
                    <input type="submit" name="new_folder" value="Create a Folder" />
                </p>
            </form>
            <?php
                if(isset($_POST['new_folder'])){
                    header("Location: create_folder.php?folder=".$file_path);
                    exit;
                    }
            ?>
            <?php // Get the filename and make sure it is valid
                if(isset($_POST['submit'])){
                    $filename = basename($_FILES['uploadedfile']['name']);
                    $full_path = sprintf("/home/asantrach/uploads/%s/%s", $username, $filename);
                    
                    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
                        echo "<p class='error'>Invalid filename</p>";
                        exit;
                    } elseif(file_exists($full_path)){
                        echo "<p class='error'>File already has been uploaded</p>";
                    } elseif($_FILES['uploadedfile']['size'] > 20000000) {
                        echo "<p class='error'>File too large. </p>";
                    }
                    
                    
                    if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
                        //header("Location: upload_success.html");
                        echo "<p class='error'>File upload was a success! </p>";
                        header("Refresh:0");
                        exit;
                    }else{
                        //header("Location: upload_failure.html");
                        echo "<p class='error'>File upload failed </p>";
                        exit;
                    }
                }
                ?>
           </div>
        </body>
    </html>