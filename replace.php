

<?php


function replacebill($line,$idis,$nbill){
  $replaced=false;
  $cad='';
  $ced='';
  $cod=array();
  $conti=0;
  $cconti=0;
  $man = json_decode($line, true);
  $i=0;
  foreach($man as $element) {
      $je=json_encode($man[$i]);
      $tr=0;
      for($a=0; $a<count($idis); $a++){
        if (strpos(' '.$je, $idis[$a]) !== false) {
          $tr=1;
          break;
        }
      }
      if($tr==1){
        //$jee=$je.','.$bill;
        array_push($cod,$je);
        $ced.= $je.',';
        $cad.= $nbill.',';
      }else{
        $cad.= $je.',';
      }
      $i+=1;
    }
    $cad=rtrim($cad, ", ");
    $llina='['.$cad.']';
    $ced=rtrim($ced, ", ");
    $lline=''.$ced.'';
    $arri = array($llina , $cod);
    return $arri;
  
}

function addbill($line,$idis){
  $pos = strrpos($line, "]");
  $li1 = substr($line, 0, $pos);
  $li2 = substr($line, $pos);
  $lin=$li1.','.$idis.$li2;
  return $lin;
  
}


///////////////////////////////
// RECEIVE POST DATA AND SETUP
// $img $too $nfile $idis(bills ids)
////////////////////////////

$dir='';
//$nfile='wallets.json';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
    $ourlist="wallets.json";
    $too = $_POST['fto'];
    $img = $_POST['ffrom'];
    $nfile = $ourlist;
    $idbills=$_POST['idbills'];
    $newbill=$_POST['newbill'];
    $idis=json_decode($idbills,true);
    $msg=$_POST['msg'];
    $nnfile=$nfile.'.tmp';
    $cad='';
    $iimg='"img":"'.$img;
    $ttoo='"img":"'.$too;
    $reading = fopen($nfile, 'r');
    $writing = fopen($nnfile, 'w');
    $replaced = false;

    ////////////////////////////////
    // MAKE ARRAY AND SEARCH FROM AND TO  
    // $lines $contim  $contto
    ////////////////////////////////
    $conti=0;
    $cconti=0;
    $cod='';
    $foryou='';
    $lines=array();
    $contto=-1;
    $contim=-1;
    $i=0;
    while (!feof($reading)) {
      $line = fgets($reading);
      if (stristr($line,$iimg)) {$contim=$i;}
      //if (stristr($line,$ttoo)) {$contto=$i;}
      array_push($lines,$line);
      $i+=1;
    }
    ////////////////////////////////
    // GET AND DELETE BILLS
    // $second  $think
    ////////////////////////////////
    $second=array();
    $think='';
    for($a=0;$a<count($lines);$a++){
      if($a==$contim){
        $se=replacebill($lines[$a],$idis,$newbill);
        array_push($second,$se[0]);
        $think=$se[1];
      }else{
        array_push($second,$lines[$a]);
      }
    }
    
    ///////////////////
    // WRITE FILE
    //
    ///////////////////
    $ns=count($second);
    //echo ''.$ns.' ';
    //for($a=0;$a<$ns;$a++){
      //fputs($writing, $third[$a]);
    //}
    $bl=implode(PHP_EOL, $second);
    $result=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $bl);
    fputs($writing,$result);
    $replaced = true;
    ///////////////////
    // END
    ///////////////////

    fclose($reading); fclose($writing);

    if ($replaced) 
    {
      //echo '<hr>REPLACED';
      rename($nnfile, $nfile);
    } else {
      //echo '<hr>NO REPLACED';
      unlink($nnfile);
    }

}}



