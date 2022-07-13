<?php
include "db_connection.php";

if (isset($_POST['submit_image']) && isset($_FILES['my_image'])) {
    // echo "<pre>";
    // print_r($_FILES['my_image']);
    // echo "</pre>";

    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    if ($error === 0) {
        if ($img_size > 2500000) {
            $em = "Your image is too large!";
            header("Location: upload.html?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = str_replace('.','-',uniqid("IMG-", true)).'.'.$img_ex_lc;
                $img_upload_path = 'Assets/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $query = "INSERT INTO images(image_url) VALUES('$new_img_name')";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    echo "Adding image to db failed.", mysqli_error($connection);
                    exit();
                }
                header("Location: display.php");
            } else {
                $em = "Incorrect file type!";
                header("Location: upload.html?error=$em");
            }
        }
    } else {
        $em = "Unknown error occurred!";
        header("Location: upload.html?error=$em");
    }

} else {
    header("Location: upload.html?Error=Error");
}
?>