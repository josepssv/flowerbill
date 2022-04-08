<?php include 'ciphre.php';
$user= $_SERVER['REMOTE_ADDR'];
$date = new DateTime();
$timestamp= $date->getTimestamp();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
    if($name=='append'){
      $myfile = fopen("collection.json", "a") or die("Unable to open file!");
    	$txt = $_POST['coord'];
      $id = $_POST['id'];
      $cid=ciphre($id,1);
      $cuser=ciphre($user,1);

      $key='"id":"';
      $keyu='"user":"';  
      $keyc='"created":"';
      $res=str_replace($key.$id, $key.$cid, $txt);
      $res=str_replace($keyu, $keyu.$cuser, $res);
      $res=str_replace($keyc, $keyc.$timestamp, $res);
    	fwrite($myfile, "\n". $res);
    	fclose($myfile);
      //echo res;
      //echo ("Recorded in database");
      //header('Location: viewer.html?id='.$id);
      //exit;
    }

    if($name=='appendBank'){
      $myfile = fopen("collection.json", "a") or die("Unable to open file!");
      $txt = $_POST['coord'];
      //$idimg = $_POST['id'];
       //$ml= json_decode($txt, true); 
       //$id=$ml[0]['id'];
      fwrite($myfile, "\n". $txt);
      fclose($myfile);
    }
  }
}
?>

