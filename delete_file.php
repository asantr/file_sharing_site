<?php
  session_start();
      if(!(isset($_SESSION['username']))){
    header("Location: first_page.php");
    exit;
    }
  if(isset($_GET['file_to_delete'])){
       $_SESSION['file_to_delete']= $_GET['file_to_delete'];
  }
  $file_to_delete = $_SESSION['file_to_delete'];
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
<!--        form to make sure someone wants to actually delete something  -->
      <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                <p>
                  Are you sure you would like to delete this file ?
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
  $username = $_SESSION['username'];
    //
    $full_path = sprintf("/home/asantrach/uploads/%s/%s", $username, $file_to_delete);
  if(isset($_POST['yes'])){
    if (is_file($full_path)){
      unlink($full_path);
      header("Location: post_login.php");
      exit;
    }
  }
  elseif(isset($_POST['no'])){
      header("Location: post_login.php");
      exit;
  }
?>