<?php include 'ciphre.php';
$user= $_SERVER['REMOTE_ADDR'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  //$name = 'limit';
  if (empty($name)) {
     echo "Name is empty";
  } else { 
     if($name=='read'){
        $nfile = 'wallets.json';
        $nid = $_POST['nid'];
        $hash = $_POST['hash'];
        $lines = file($nfile);
        $n=-1;
        for($a=0;$a<count($lines);$a++){
           if(strrpos($lines[$a],$hash)>0){
              $n=$a;
              break;
           }
        }
        $ml= json_decode($lines[$n], true); 
        for($a=0;$a<count($ml);$a++){
           if(strrpos($ml[$a],$nid)>0){
              $n=$a;
              break;
           }
        }
        echo $ml[$n]; 
    }
    
    if($name=='limit'){
        $nwallets=0;
        $nfile = 'wallets.json';
       // $nid = $_POST['nid'];
        $hash = $_POST['hash'];
        $chash=ciphre($hash,1);
        //$hash ='gmwp9V4rGpqvhPwFHaX728Z1Bvmi2He4VIbGoNCGL5VSuD1hPH';
        $lines = file($nfile);
        $n=-1;
        $nwallets=count($lines)-1;
        $key='"id":"'.$chash;
        for($a=0;$a<count($lines);$a++){
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

        //for($a=0;$a<count($lines);$a++){      if(strrpos($lines[$a],$key)>0){        $n=$a;    break;  
         }
        }
        if($n==-1){
           echo '{"bills":0,"amount":0,"nwallets":0,"img":"-1"}'; 
        }else{
           $ml= json_decode($lines[$n], true); 
           $amount=0;
           $bills=count($ml)-1;
           $img=$ml[0]['img'];
          if(count($ml)>0){
              for($a=1;$a<count($ml);$a++){

                 $amount+=$ml[$a]['am'];
              }
          }
           echo '{"bills":'.$bills.',"amount":'.$amount.',"nwallets":'.$nwallets.',"img":"'.$img.'"}'; 
        }
    }
    if($name=='info'){
        $nwallets=0;
        $nfile = 'wallets.json';
        $lines = file($nfile);
        $n=0;
        $nwallets=count($lines);
        //WE NEED CREATION DATE
        //$lines[1];
        echo '{"nwallets":'.$nwallets.',"initbank":""}'; 
       
    }
    if($name=='hash'){
        $nwallets=0;
        $nfile = 'wallets.json';
       // $nid = $_POST['nid'];
        $img = $_POST['img'];
        //$hash ='gmwp9V4rGpqvhPwFHaX728Z1Bvmi2He4VIbGoNCGL5VSuD1hPH';
        $lines = file($nfile);
        $n=-1;
        $nwallets=count($lines)-1;
        $key='"img":"'.$img;
        for($a=0;$a<count($lines);$a++){
           if(strrpos($lines[$a],$key)>0){
              $n=$a;
              break;
           }
        }
        $ml= json_decode($lines[$n], true); 
        $chash=$ml[0]['id'];
        $hash=ciphre($chash,-1);
        echo '{"cid":"'.$chash.'","id":"'.$hash.'"}'; 
    }
   if($name=='user'){
       $ourlist="wallets.json";
       $lines = file($ourlist);
       $n=-1;
       $cuser=ciphre($user,1);
       $key='"user":"'.$cuser;
       for($a=0;$a<count($lines);$a++){
          if(strrpos($lines[$a],$key)>0){
             $n=$a;
             break;
          }
       }
       if($n==-1){
            echo $user.' ';
       }else{
           $line = json_decode($lines[$n], true);
           $hash=ciphre($line[0]['id'],-1);
           echo 'ok'.$hash;
      }
    }
    if($name=='users'){
      $ourlist="wallets.json";
       $lines = file($ourlist);
       $n=-1;
       $cuser=ciphre($user,1);
       $key='"user":"'.$cuser;
       for($a=0;$a<count($lines);$a++){
          if(strrpos($lines[$a],$key)>0){
             $n=$a;
             break;
          }
       }

       if($n==-1){
            echo '';
       }else{
           $ch='';
           for($a=0;$a<count($lines);$a++){
              //if($a!=$n && count($lines[$a])>50){
               if($a!=$n && strlen($lines[$a])>50 ){
                 $line = json_decode($lines[$a], true);
                 if(is_null($line[0]['name'])!= 1){
                     $ch.='<button type="button" class="button hashlink" style="display:inline-block" value="'.$line[0]['img'].'" > '.$line[0]['name'].'</button>';
                  }
               }
           }
           echo $ch;
      }
    }
  }
}
?>

