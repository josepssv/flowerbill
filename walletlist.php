<style>
  body,html{margin: 20px 100px;}
  .linkbut {
  font: bold 11px Arial;
  text-decoration: none;
  background-color: #EEEEEE;
  color: #333333;
  padding: 2px 6px 2px 6px;
  border-top: 1px solid #CCCCCC;
  border-right: 1px solid #333333;
  border-bottom: 1px solid #333333;
  border-left: 1px solid #CCCCCC;
  border-radius: 4px;
}
</style>
<script>
var cad=''
dir='https://waterval-project.com/FB/s022/';
dir='';
var v=[];
<?php include 'ciphre.php';


$f=array();
$chod='';
$except=array('index.html','basic.jpg');
$imgspath='upload/';
$files = scandir($imgspath);             
$total = count($files);            
$images = array();   
$pil=0;
if ($handle = opendir($imgspath)) {

    while (false !== ($entry = readdir($handle))) {
        $pil=0;
        if ($entry != "." && $entry != "..") {
           $d= $entry;
            //for($a=0;$a<count($except);$a++){
                //if (in_array($d, $except[$a])){
              if (in_array($entry, $except)){
                   $pil=1;
                   
                }
            //}
            if($pil==0){
                  $e=str_replace(".jpg","",$d);
                  array_push($images,$e);   
                  $chod .= '<div style="display:inline-block;margin-left:30px;"><img src="'.$imgspath.$d.'" width="80px"><br>'.$d.'</div>';  
            }
         }
      }   
    closedir($handle);
}

/*
for($x = 0; $x <= $total; $x++){               
      $ise=1 ;   
      for($a=0;$a<count($except);$a++){
        $ise=strcmp($files[$x],$except[$a]);
        //echo  ''.$except.' '.$files[$x].'<br>';
        break;
      }   
      if($ise!=0){

        array_push($images,$files[$x]);    
      }    
   }                          
};
*/
$imgwallet = array(); 
$idwallet = array();
$cad='';
$chad='';
$handle1 = fopen("wallets.json", "r");
if ($handle1) {
    while (($line = fgets($handle1)) !== false) {
      if (strlen($line)>10){
          $ld=json_decode($line, true);

          if (isset($ld[0])){
          //if (count($ld[0])>0){
            $ld[0]['img']=preg_replace('/\s+/', '',$ld[0]['img']);
            $cid=ciphre($ld[0]['id'],-1);
            $cid=preg_replace('/\s+/', '',$cid);
            array_push($imgwallet,$ld[0]['img']); 
            array_push($idwallet,$ld[0]['id']); 
            //if(strlen($ld[0]['id'])>10){

             //$cad .= '<a href="wallet.html?id='.$cid.'">'.$ld[0]['img'].'</a><br>'."\n"; 
              //$cad .= '<a href="'.$imgspath.$ld[0]['img'].'.jpg">'.$ld[0]['img'].'</a><br>'."\n"; 
            $cad .= '<a href="clean.php?img='.$ld[0]['img'].'">'.$ld[0]['img'].'</a><br>'."\n"; 
             $chad .= '<div style="display:inline-block;margin-left:30px;"><img src="'.$imgspath.$ld[0]['img'].'.jpg" width="80px"><br>'.$ld[0]['img'].'</div>'."\n";    
            }
        }
      }
       
    }
 
/*
if ($handle1) {
    while (($line = fgets($handle1)) !== false) {
      $v=$line;
      $v = str_replace("\r\n", "\n", $v); // windows -> unix
      $v = str_replace("\r", "\n", $v);   // remaining -> unix
      //array_push($cod,$je);
      ?>
       v.push(<?php echo($v); ?>)
       
       <?php
    }

    fclose($handle1);
} else {
    // error opening the file.
} 





?>

for (var a=0;a<v.length;a++){
  cad += '<a href="'+dir+'wallet.html?id='+v[a][0].id+'">'+v[a][0].img+'</a><br>\n';

}
document.write(cad)
*/
?>
</script>



<?php
$delete=false;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['remove'])) {
    $delete=true;
  }
}
function get_decorated_diff($old, $new){
    $from_start = strspn($old ^ $new, "\0");        
    $from_end = strspn(strrev($old) ^ strrev($new), "\0");

    $old_end = strlen($old) - $from_end;
    $new_end = strlen($new) - $from_end;

    $start = substr($new, 0, $from_start);
    $end = substr($new, $new_end);
    $new_diff = substr($new, $from_start, $new_end - $from_start);  
    $old_diff = substr($old, $from_start, $old_end - $from_start);

    $new = "$start<ins style='background-color:#ccffcc'>$new_diff</ins>$end";
    $old = "$start<del style='background-color:#ffcccc'>$old_diff</del>$end";
    return array("old"=>$old, "new"=>$new);
}




echo $cad;
echo $chad;
echo '<hr>';
echo $chod;
echo '<hr>';
$imgwallet=array_filter($imgwallet);

echo count($imgwallet).'<br>';
print_r($imgwallet);
echo '<hr>';
echo count($images).'<br>';
print_r($images);
echo '<hr>';
echo 'DIFFERENCES<br>';
$who=array();
for($a=0;$a<count($images);$a++){
  $filtro=preg_replace('/\s+/', '',$images[$a]);
  $doi=0;
  for($i=0;$i<count($imgwallet);$i++){
      //if($filtro==$images[$i]){
      $tro=preg_replace('/\s+/', '',$imgwallet[$i]);
        //if($filtro == $tro){
        //echo '-'.$filtro.'---'. $tro.'-<br>';
       if(strcmp($filtro, $tro) == 0) {
          //print(get_decorated_diff($filtro, $images[$i]));
            //echo $filtro.'+++'. $tro.'<br>';
            $doi=1; 
       }
    }
    if($doi==0){array_push($who,$a);}
}




$todelete=array();
echo '<hr>';
if (count($who)>0){
  print_r($who);
}
echo '<hr>';
$c=0;
for($a=0;$a<count($who);$a++){
  $ig= $images[$who[$c]].'.jpg';
   
   array_push($todelete,$ig);
   if($delete){
    echo 'This has been removed '.$ig.' <br>';
    unlink($imgspath.$images[$who[$c]].'.jpg');
  }else{
    echo 'This should be removed '.$ig.' <br>';
  }
    $c+=1;
    if($c>=count($who)){
      $c=0;
    }
}
if(!$delete){
echo '<hr>';
echo '<div><a class="linkbut" href="walletlist.php?remove=true">Remove this images</a></div>';
echo json_encode($todelete);
}
//unlink($imgspath.$images[$who[$c]].'.jpg');


/*
$result =array_diff($images,$imgwallet);
$vd3=print_r($result);
//$vd3=implode("<br>", $result);
echo $vd3;
//-->echo $imgwallet;
echo '<hr>';

for($a=0;$a<count($result);$a++){
  $s=$result[$a];
  echo $s;
  echo '</br>';
}



$vd1=implode("<br>", $imgwallet);
echo $vd1;
//-->echo $imgwallet;
echo '<hr>';
//print_r( $idwallet);
//echo json_encode($imgwallet);

//print_r($images);
$vd=implode("<br>", $images);
echo $vd;
echo '<hr>';


$ch='With wallet: <br>';
$chi='Without wallet: <br>';
//$je=json_encode($imgwallet);
//echo $je;<br>'.
for($a=0;$a<count($images);$a++){
  $s=substr($images[$a],0,10);

  //$r = in_array($s, $imgwallet);
 $r=strpos($s,$vd1);
  echo '-'.$r.'-<br>';
  if ($r>-1){
      $chi.=$images[$a].'<br>';
      echo 'no';
  }else{
    $chi.=$images[$a].'<br>';
    //$ch.=json_encode($images[$a]).'<br>';
    //$ch.=$a].'<br>';
  }
}

echo '<hr>';
print($ch);
echo '<hr>';
print($chi);
*/
?>