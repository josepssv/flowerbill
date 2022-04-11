<?php


function removebill($line,$idis){
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
        array_push($cod,$je);
        $ced.= $je.',';
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


function getbill($line){
  //echo "<br> ".$line;
  $nowY = date('Y', time());
  $nowM = date('M', time());
  //$d=strtotime("+2 Months");
  //$expire=date("M Y", $d);
  $replaced=false;
  $cad='';
  $ced='';
  $cod=array();
  $conti=0;
  $cconti=0;

  $man = json_decode($line, true);
  $i=0;
  $sel=array();
  foreach($man as $element) {
      $je=json_encode($man[$i]);
      $tr=0;
      if($i>0){
        //$key='"exp":"';
        //echo '<hr>'.$je.'<hr>';
        
        $datexp=$man[$i]["exp"];
       
        $MY= explode(" ", $datexp);
        
        $Y=intval($MY[1]);
        $nY=intval($nowY);
        $M1 = date_parse($MY[0]);
        $M=$M1['month'];
        $nM1 = date_parse($nowM);
        $nM=$nM1['month'];
        //echo "<br>".$Y.' '.$nY.' '.$M.' '.$nM.'<hr>';
        //var_dump($M['month']);
        
        if(($nM>$M && $Y==$nY )|| $Y<$nY){ 
           array_push($sel,$man[$i]["id"]);
           echo '<hr>deleted this<br>'.$man[$i]["id"].'<br>'.$datexp.'<br>'.$M.' '.$Y.' - '.$nM.' '.$nY.'<br>';
        }
      }
      $i+=1;
    }
    //echo '<hr>'.var_dump($sel).'<br>';
    return $sel;
  
}


function addbill($line,$idis){
  $pos = strrpos($line, "]");
  $li1 = substr($line, 0, $pos);
  $li2 = substr($line, $pos);
  $lin=$li1.','.$idis.$li2;
  return $lin;
  
}


///////////////////////////////
// RECEIVE GET DATA AND SETUP
// $img $too $nfile $idis(bills ids)
////////////////////////////

$dir='';
//$nfile='wallets.json';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // collect value of input field
  $name = $_GET['img'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
    $ourlist="wallets.json";
    //$too = $_POST['fto'];
    $img = $name;
    $nfile = $ourlist;
    //-->$idbills=$_POST['idbills'];
    //-->$idis=json_decode($idbills,true);
    //$msg=$_POST['msg'];
    $nnfile=$nfile.'.tmp';
    $cad='';
    $iimg='"img":"'.$img;
    $reading = fopen($nfile, 'r');
    $writing = fopen($nnfile, 'w');
    $replaced = false;
   
    ////////////////////////////////
    // MAKE ARRAY AND SEARCH FROM AND TO  
    // $idis $lines $contim  $contto
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
    
    $idis=getbill($lines[$contim]);



    ////////////////////////////////
    // GET AND DELETE BILLS
    // $second  $think
    ////////////////////////////////
    $second=array();
    $think='';
    for($a=0;$a<count($lines);$a++){
      if($a==$contim){
        $se=removebill($lines[$a],$idis);
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


