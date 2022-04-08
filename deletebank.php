<?php


function removebill($line,$ids){
  $replaced=false;
  $cad='';
  $ced='';
  $cod=array();
  $conti=0;
  $cconti=0;
  //////////////////////////
  /////  REMOVE ,
  /////////////////////////
  //$line=rtrim($line, ", ");
  $last=substr($line, -1);
  if($last==','){
    $line=substr($line, 0, -1);
  }
  $last=substr($line, -2,-1);
  if($last==','){
    $line=substr($line, 0, -2);
  }

  $line='['.$line.']';
  $decj = json_decode($line, true); 


  //echo '<br>linetrim '.json_encode($decj);

  //////////////////////////
  //  CATCH EQUAL LINE
  /////////////////////////

  $i=0;
  $cont=0;
  $idis=json_decode($ids, true);
  //foreach($decj as $values ) {
  for ($i = 0; $i < count($decj); $i++) {
    //echo 'value: '. $values;
       //echo '<br> value: '. json_encode($decj[$i]);
      //$je=json_encode($values['id']);
      $je=$decj[$i];
      $ije=json_encode($je);
      $tr=0;
      for($a=0; $a<count($idis); $a++){
        //if ($arraysAreEqual = ($je == $idis[$a])) {
          $iidis=json_encode($idis[$a]);
          //echo '<br> two vals : '. $ije .'<br>:   '. $iidis;
         if ( strcmp($ije,$iidis)==0){
            $cont+=1;
            //$ced.= $je.',';
            $ced.= $ije.',';
            //echo '<p style="color:#00f;"> No tomo: <br>'. $ije. '<br> '. $iidis .'</p>';

          }else{
            array_push($cod,$decj[$i]);
            //$cad.= json_encode($decj[$i]).',';
            //echo '<p style="color:#f00;">Tomo: <br>'. $ije. '<br> '. $iidis .'</p>';
            break;
          }
      }
      //$i+=1;
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


///////////////////////////////
// RECEIVE POST DATA AND SETUP
// $img $too $nfile $idis(bills ids)
////////////////////////////



    $ourlist="wallets.json";
    $ourbank="bank.json";
    $too = $_POST['fto'];
    $img = $_POST['ffrom'];
    $nfile = $ourlist;
    $nfilebank=$ourbank;
    $idbills=$_POST['idbills'];
    $codes = $_POST['codes'];
    $idis=json_decode($idbills,true);
    $msg='msg';
    $nnfile=$nfile.'.tmp';
    $nnfilebank=$nfilebank.'.tmp';
    $cad='';
    $iimg='"img":"'.$img;
    $ttoo='"img":"'.$too;
    //$reading = fopen($nfile, 'r');
    //$writing = fopen($nnfile, 'w');
    $readingbank = fopen($nfilebank, 'r');
    $writingbank = fopen($nnfilebank, 'a');

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

      array_push($second,$sol);
      //fputs($writing,$sol);
      fwrite($writingbank,$sol);
      $i+=1;
    }

    /*$bl=implode(PHP_EOL, $second);
    $result=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $bl);
      //echo $result;
    //fputs($writing,$result); 
    //echo '</pre>';
    fwrite($writing, $result);
    */
    //file_put_contents($writing, implode(PHP_EOL, $second));
    //fputs($writing,implode(PHP_EOL, $second)); 

    $replaced =  true;
    ///////////////////
    // END
    ///////////////////

    //fclose($reading); fclose($writing);
    fclose($readingbank); fclose($writingbank);

    if ($replaced) 
    {
      //echo '<hr>REPLACED';
      //rename($nnfile, $nfile);
      rename($nnfilebank, $nfilebank);
    } else {
      //echo '<hr>NO REPLACED';
      //unlink($nnfile);
      unlink($nnfilebank);
    }





