<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
    $n = $_POST['n'];
    $query = $_POST['query'];
  	$nfile = 'bank.json';
    $lines = file($nfile);
    if($query=='all'){
      $all='';
       for($a=0;$a<count($lines);$a++){
          if(strlen($lines[$a])>20){
            //$dall=rtrim($lines[$a], ", ");
            $dall=$lines[$a];
            $all.=$dall;

          }
        }
      $all= rtrim($all, ", ");
      if(strlen($all)>50){
        echo $all; 
      }else{ echo '{}';}
  	  //$nu=count($lines)-1;
        
       
   }
  }
}
?>

