<?php include 'ciphre.php';
$user= $_SERVER['REMOTE_ADDR'];
$date = new DateTime();
$timestamp= $date->getTimestamp();

function addbill($line,$idis){
  $pos = strrpos($line, "]");
  $li1 = substr($line, 0, $pos);
  $li2 = substr($line, $pos);
  $lin=$li1.','.$idis.$li2;
  return $lin;

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
  
  if($name=='into'){ 
    $writing = fopen("wallets.json", 'w') or die("Unable to open file!");
    $txt = $_POST['coord'];
    $n = $_POST['n'];
    $iimg = $_POST['iimg'];
    $i=0;
    $lines=array();
    while (!feof($writing)) {
      $line = fgets($writing);
      if (stristr($line,$iimg)) {
        $je=trim($line, ']');
        $je.=$txt.']';
        array_push($lines,$je);
      }else{
        array_push($lines,$line);
      }
      $i+=1;
    }
    fwrite($writing, "\n". $txt);
    fclose($writing);
  }

    if($name=='append'){ 
    $txt = $_POST['coord'];
    $hash = $_POST['hash'];
    //$dd = json_decode($txt, true);
    //$id=$dd[0]['id'];
    $eid=ciphre($hash,1);
    //$dd[0]['id']=$eid;
   /* $reading = fopen("wallets.json", 'r') or die("Unable to open file!");
    $lines=array();
    while (!feof($reading)) {
      $line = fgets($reading);
      if(strlen($line)>4){
        array_push($lines,$line);
      }
    }
    fclose($reading);
    */
    //$txt1=json_encode($dd);
    $txt1=str_replace($hash, $eid, $txt);
    $myfile = fopen("wallets.json", "a") or die("Unable to open file!");
    fwrite($myfile, "\n". $txt1);
    fclose($myfile);
  }

  if($name=='more'){ 
    if(count($lines)<2){
      $mybank = fopen("bank.json", "a") or die("Unable to open file!");
      $txt = $_POST['coord'];
      $dd = json_decode($txt, true);
      $bankline=array();
      for($a = 1; $a<count($dd);$a++ ){
         array_push($bankline,$dd[$a]);
      }
      $rbank = json_encode($bankline);
      $rbank=trim($rbank, '[');
      $rbank=trim($rbank, ']');
      $rbank.=',';
      fwrite($mybank, "\n". $rbank);
      fclose($mybank);
      echo 'Writed in bank  ;  ';
    }

  }
    //echo ("Recorded in database");
    //header('Location: viewer.html?id='.$id);
    //exit;
  }
}
?>
