<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
  
    $writing = fopen("bank.json", 'a') or die("Unable to open file!");
    $txt = $_POST['coord'];
    $txt=trim($txt, '[');
    $txt=trim($txt, ']');
    $txt.=',';
    fwrite($writing, "\n". $txt);
    fclose($writing);
  
    //echo ("Recorded in database");
    //header('Location: viewer.html?id='.$id);
    //exit;
  }
}
?>
