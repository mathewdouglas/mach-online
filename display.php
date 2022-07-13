<?php
include "db_connection.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="upload.html">Back</a>
    <div class="alb">
    <?php
        $sql = "SELECT * FROM images ORDER BY id ASC";
        $res = mysqli_query($connection, $sql);

        if (mysqli_num_rows($res) > 0) {
            while ($images = mysqli_fetch_assoc($res)) { ?>
                <img src="Assets/<?=$images['image_url']?>" alt="" draggable="false">
        <?php   }
        }?>
        </div>
</body>
<style>
    img {
        height: 400px;
        border-radius: 20px;
    }
</style>
</html>