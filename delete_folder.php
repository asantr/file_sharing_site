<?php
  session_start();
  if(isset($_GET['folder_to_delete'])){
       $_SESSION['folder_to_delete']= $_GET['folder_to_delete'];
  }
  $folder_to_delete = $_SESSION['folder_to_delete'];
?>
<!DOCTYPE html>
  <html lang='en'>
    <head>
      <title>
        Delete Files
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
<!--     check to see if they want to delete the entire folder   -->
      <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                  Are you sure you would like to delete this folder and it's contents ?
                </p>
                <p>
                    <input type="submit" name="yes" value="Yes" />
                    <input type="submit" name="no" value="No" />
                </p>
            </form>
      </div>
    </body>
  </html>


<?php
//https://stackoverflow.com/questions/4952194/deleting-a-server-file
      if(!(isset($_SESSION['username']))){
    header("Location: first_page.php");
    exit;
    }
  $username = $_SESSION['username'];
  
  $full_path = sprintf("/home/asantrach/uploads/%s/%s", $username, $folder_to_delete);
  if(isset($_POST['yes'])){
    
//  this function came from this discussion https://stackoverflow.com/questions/3338123/how-do-i-recursively-delete-a-directory-and-its-entire-contents-files-sub-dir
//function goes through and recurrsively deletes files in folders so that we can call rmdir
      function recurseRmdir($full_path) {
        $files = array_diff(scandir($full_path), array('.','..'));
        foreach ($files as $file) {
          (is_dir($full_path.'/'.$file)) ? recurseRmdir($full_path.'/'.$file) : unlink($full_path.'/'.$file);
          echo $file ."was deleted";
        }
        return rmdir($full_path);
      }
      recurseRmdir($full_path);
      header("Location: post_login.php");
      exit;
  }
  elseif(isset($_POST['no'])){
      header("Location: post_login.php");
      exit;
  }
?>