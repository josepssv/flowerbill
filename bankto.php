<?php include 'ciphre.php';

function removebill($line,$idis){
  $replaced=false;
  $cad='';
  $ced='';
  $cod=array();
  $conti=0;
  $cconti=0;
  //$line=rtrim($lini, ", ");
  //$decj = json_decode($line, true);
  $decj = array_values(json_decode($line, true));
  $i=0;
  $cont=0;
  foreach($decj as $values ) {
    echo $values;
  //for ($i = 0; $i < count($decj); $i++) {
      //$je=json_encode($values['id']);
      $je=$values['id'];
      
      $tr=0;
      for($a=0; $a<count($idis); $a++){
        //if ($arraysAreEqual = ($je == $idis[$a])) {
         if ( strcmp($je,$idis[$a])){
          $cont+=1;
          $ced.= $je.',';
        }else{
          array_push($cod,$je);
          $cad.= $je.',';
        }
      }
      $i+=1;
    }
    //$cad=rtrim($cad, ", ");
    $llina=''.$cad.'';
    //$ced=rtrim($ced, ", ");
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

function ishash($line,$hash){
  $ml= json_decode($line, true); 
  $chash=$ml[0]['id'];
  $hash1=ciphre($chash,-1);
  if( strcmp($hash,$hash1)==0){
    return true;
  }else{
    return false;
  }
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
    echo "It has not been posible";
   
  } else { 
    $ourlist="wallets.json";
    $ourbank="bank.json";
    $too = $_POST['fto'];

    $img = $_POST['ffrom'];
    $nfile = $ourlist;
    $nfilebank=$ourbank;
    $idbills=$_POST['idbills'];
    $codes = $_POST['codes'];
    $idis=json_decode($idbills,true);
    $msg=$_POST['msg'];
    $nnfile=$nfile.'.tmp';
    $nnfilebank=$nfilebank.'.tmp';
    $cad='';
    $iimg='"img":"'.$img;
    //$ttoo='"img":"'.$too;



    $reading = fopen($nfile, 'r');
    $writing = fopen($nnfile, 'w');
    $readingbank = fopen($nfilebank, 'r');
    $writingbank = fopen($nnfilebank, 'w');

    $replaced = false;
    
    $codei=json_decode($codes);
    $first=array();
    for($a=0; $a<count($codei); $a++){
       // $cad="'".json_encode($codei[a])."'";
       $comp=json_encode($codei[$a]);
        array_push($first,$comp);
    }

    ////////////////////////////////
    // MAKE ARRAY BANK  
    // $lines $second
    ////////////////////////////////

    $conti=0;
    $cconti=0;
    $cod='';
    $foryou='';
    $lines=array();
    $second=array();
    $i=0;
    $contto=-1;
    while (!feof($readingbank)) {
      $line = fgets($readingbank);
      $sol=str_replace($first, '', $line);
      $sol=str_replace(',,', ',', $sol);
      //echo ('<br> line: '. $i.' '.$sol);
      $pos = strpos($sol, ',');
      if ($pos ==0) {
          //$sol = substr_replace($sol, ',', $pos, strlen(','));
        $sol=substr($sol, 1);
      }

      //$postt = strpos($line, $too);
      $postt =ishash($line,$too);
      if($postt){$contto=$i;}
      array_push($second,$sol);
      //fputs($writing,$sol);
      fwrite($writingbank,$sol);
      $i+=1;
    }



 
    ///////////////////////////////
    // MODIFY EXPIRATION DATE BILLS
    // $je
    ///////////////////////////////
    $codei=json_decode($codes);
    $medium=array();
    $now = date('M Y', time());
    $d=strtotime("+2 Months");
    $expire=date("M Y", $d);
    echo '<div style="color:#f00;">'.json_encode($codei).'</div>';
    for($a = 0; $a<count($codei);$a++ ){
      //$dd = json_decode($codei[$a], true);
      $dd = $codei[$a];
       echo '<div style="color:#00f;">'.json_encode($dd).'</div>';
      $dd->{'emi'}=$now;
      $dd->{'exp'}=$expire;
      //$dd['emi'] = 'dksjd'; //$now;
      //$dd['exp'] = 'dksjd'; //$expire;
      array_push($medium,$dd);
    }
    $je=json_encode($medium);
    $je=trim($je, '[');
    $je=trim($je, ']');
  
  
    ///////////////////
    // ADD BILLS TO
    // $je to $second
    ///////////////////
    $i=0;
    $lines=array();
    $contto=-1;
    while (!feof($reading)) {
      $line = fgets($reading);
      $postt =ishash($line,$too);
      if($postt){$contto=$i;}
      //if (stristr($line,$too)) {$contto=$i;}
      array_push($lines,$line);
      $i+=1;
    }

    $ns=count($lines);
    //echo ''.$ns.' ';
    $third=array();
    for($a=0;$a<$ns;$a++){
      if($a==$contto){
        $se=addbill($lines[$a],$je);
        array_push($third,$se);
      }else{
        array_push($third,$lines[$a]);
      }
    }
    echo '<hr>'.json_encode($third).'<br>';

    ///////////////////
    // WRITE FILE
    //
    ///////////////////
    $ns=count($third);
    //echo ''.$ns.' ';
    //for($a=0;$a<$ns;$a++){
      //fputs($writing, $third[$a]);
    //}
    $bl=implode(PHP_EOL, $third);
    $result=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $bl);
    fputs($writing,$result);


    
    $replaced = true;
    ///////////////////
    // END
    ///////////////////
    fclose($reading); fclose($writing);
    fclose($readingbank); fclose($writingbank);

    if ($replaced) 
    {
      //echo '<hr>REPLACED';
      rename($nnfile, $nfile);
      rename($nnfilebank, $nfilebank);
    } else {
      //echo '<hr>NO REPLACED';
      unlink($nnfile);
      unlink($nnfilebank);
    }

}

}

