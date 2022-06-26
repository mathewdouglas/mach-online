<?php
$connection = mysqli_connect("127.0.0.1:3306", "u163583148_mathewdouglas", "Jpue/CKGj*1", "u163583148_machonline");
if (!$connection) {
    echo "Cannot connect to MySQL. ", mysqli_connect_error($connection);
    header("Location: index.php?Connection=False");
    exit();
}
?>