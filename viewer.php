<?php include 'ciphre.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
     echo "Name is empty";
  } else { 
     if($name=='read2'){
         $nfile = 'wallets.json';
         //$n = $_POST['n'];
         $n=0;
         $hash = $_POST['hash'];
         $chash=ciphre($hash,1);
         
         //$key='"id":"'.$chash;
         $key=$chash;
         
         $b='';
         $lines = file($nfile);
         for($a=0;$a<count($lines);$a++){
            //$c = str_contains($lines[$a],$key);
            //$b.=$lines[$a];
            //$b.= strval($c) .' - ';
            if(strlen($lines[$a])>100){
               //$ch=str_replace($key, $hash, $lines[$a]);

                $jse= json_decode($lines[$a]);
                $rjse=$jse[0]->{'id'};
                $crj=ciphre($rjse,-1);


              //if(strpos($ch,$hash)!==false){
               if( strcmp($crj,$hash)==0){
                //if($c>0){
                 $n=$a;
                 break;
               }
            }
         }
         //echo $b.' '.count($lines).' '. $chash .' >'. $n .'< '.$key .' '.$lines[$n];//; 
         echo $lines[$n];
      }
      if($name=='read'){
        $nfile = 'collection.json';
        $n = $_POST['n'];
        $hash = $_POST['hash'];
        $lines = file($nfile);
        $chash=ciphre($hash,1);
        $key='"id":"'.$chash;
        for($a=0;$a<count($lines);$a++){
        
           if(strrpos($lines[$a],$key)>0){
              $n=$a;
              break;
           }
        }
        echo $lines[$n]; 
      }
      if($name=='readBank'){ 
        $nfile = 'collection.json';
        $n = $_POST['n'];
        $hash = $_POST['hash']; 
        $chash=ciphre($hash,1);
       //$chash=ciphre($hash,1);
        $datenow= $_POST['datenow'];
        $lines = file($nfile);
        if(count($lines)>0){
           for($a=0;$a<count($lines);$a++){
              if(strrpos($lines[$a],$chash)>0 && strrpos($lines[$a],$datenow)>0){
                 $n=$a;
                 break;
              }
           }
           echo $lines[$n];
        }
      }
      if($name=='isIn'){ 
        $nfile = 'wallets.json';
        $n = -1;
        $hash = $_POST['hash'];
         $chash=ciphre($hash,1);
        $lines = file($nfile);
        //$key=$chash;
         $key='"id":"'.$chash;
        for($a=0;$a<count($lines);$a++){
           if(strrpos($lines[$a],$key)>0){
              $n=$a;
              break;
           }
        }
        echo $n; 
      }
  }
}
?>

