<?php
$connection = mysqli_connect("127.0.0.1:3306", "u810484942_mathewdouglas", "Jpue/CKGj*1", "u810484942_db");
if (!$connection) {
    echo "Cannot connect to MySQL. ", mysqli_connect_error($connection);
    header("Location: index.php?Connection=False");
    exit();
}
?>