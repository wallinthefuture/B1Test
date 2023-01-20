<?php
include_once "get_upload_files.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parsing csv files</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="container">
    <form class="form" action="parsing_csv.php" method="post" enctype="multipart/form-data">
        <div>

            <label for="customFileInput">Select file:</label>
            <input  type="file" name="file">


            <div>
                <input class="btn" type="submit" name="submit" value="Upload">
            </div>
        </div>
    </form>
    <div>
        <label>
            Upload Files
        </label>

        <?php
        getUploadFiles();
        ?>
    </div>
    <div>
        <a class="btn" href="get_info_about_users.php">Get info about users</a>
    </div>
</div>
</body>
</html>


