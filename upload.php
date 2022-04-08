<?php
function Thumbnail($url, $filename, $width = 800, $height = true) {

 // download and create gd image
 $image = ImageCreateFromString(file_get_contents($url));

 // calculate resized ratio
 // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
 $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;

 // create image 
 $output = ImageCreateTrueColor($width, $height);
 ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));

 // save image
 ImageJPEG($output, $filename, 800); 

 // return resized image
 //return $output; // if you need to use it
 return true;
}





$uploadOk = 1;
$target_dir = "upload/";
$iden=$_POST["iden"];
$target_file_concrete = $target_dir . $iden.'.jpg';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, try again.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
  echo "Sorry, only JPG, JPEG, PNG  files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  
  //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $nw= 800;
    //$thumbsrc = $target_dir.$iden.".jpg";
    $ti= Thumbnail($_FILES["fileToUpload"]["tmp_name"], $target_file_concrete, $nw);
   if($ti){ 
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

  } else {
    echo "Sorry, there was an error uploading your file.  Try again";
  }
}





?>

