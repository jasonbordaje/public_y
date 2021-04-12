<?php

include '../includes/dbconfig2.php';
header('Access-Control-Allow-Origin: *');


$new_image_name = urldecode($_FILES["file"]["name"]).".jpg";
//move_uploaded_file($_FILES["file"]["tmp_name"], "../user_avatar/1/".$new_image_name);

function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}



if($_FILES['file']['size'] > 50000){
	$d = compress($_FILES["file"]["tmp_name"], "../user_avatar/1/".$new_image_name, 10);
}else{
	move_uploaded_file($_FILES["file"]["tmp_name"], "../user_avatar/1/".$new_image_name);
}


session_start();
$id = $_SESSION['loginid'];

$query = "UPDATE mst_user SET avatar = 'user_avatar/1/$new_image_name' where id = $id";
$conn2->query($query);
if(!$conn2){
    echo mysqli_error($conn2);
}
?>