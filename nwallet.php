<?php include 'ciphre.php';
$user= $_SERVER['REMOTE_ADDR'];
$par=array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 36, 38, 40);

function generatekey($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function createCopyImage($user_id) {
    $res = copy("upload/basic.jpg", "upload/".$user_id.".jpg");
    return 'image'.($res ? '' : ' not').' created';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['name'];
  if (empty($name)) {
    echo "Name is empty";
   
  } else { 
    if($name=='nwallet'){
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
            $created = date('M Y', time());  
            $key1=generatekey(50);
            $key2=generatekey(50);
            createCopyImage($key1);
            $myfile = fopen($ourlist, "a") or die("Unable to open file!");
            $ckey2=ciphre($key2,1);
            $txt = '[{"img":"'.$key1.'","w":800,"h":1042,"n":20,"W":200,"o":0,"d":333.33333333333337,"id":"'.$ckey2.'","msg":"","created":"'.$created.'","user":"'.$cuser.'"}]';
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
            echo $key2;
          }
      }  
      if($name=='nWallet'){
          $img = $_POST['img'];
          $emit=$_POST['emit'];
          $expir=$_POST['expir'];
          $person=$_POST['person'];
          
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
            list($w, $h)= getimagesize('upload/'.$img.'.jpg');
            //$w=$wh[0];
            //$h=$wh[1];
            $ix = rand(0,$w);
            $iy = rand(0,$h);
            $W=200;
            //$diagonal = rand($W / 2, $W);
            $diagonal = mt_rand (($W/2)*10, $W*10) / 10;
            $slices = $par[rand(0,count($par)-1)];
            $ofsset = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            $created = date('M Y', time());  
            //$key1=generatekey(50);
            $key2=generatekey(50);
            //createCopyImage($key1);
            $myfile = fopen($ourlist, "a") or die("Unable to open file!");
            $ckey2=ciphre($key2,1);
            if(strlen($person)==0){
              $person=substr($img,0,4);
            }
            $billcode_1=generatekey(10);

             $initxt = '{"img":"'.$img.'","w":800,"h":'.$h.',"n":20,"W":200,"o":0,"d":333.33333333333337,"id":"'.$ckey2.'","msg":"","created":"'.$created.'","user":"'.$cuser.'","name":"'.$person.'","harmony":""}';
            
             $newbill_1='{"x":'.$ix.',"y":'.$iy.',"n":'.$slices.',"d":'.$diagonal.',"o":'.$ofsset.',"i":"'.$img.'","exp":"'.$expir.'","emi":"'.$emit.'","am":1,"id":"'.$billcode_1.'","title":"Write title","msg":"","key":"","notes":""}';
            //echo $initxt
            //echo $initxt.' '.$newbill_1 ;
            $txt='['.$initxt.','.$newbill_1.']';
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
            echo $key2;
          }else{
             $line = json_decode($lines[$n], true);
             $hash=ciphre($line[0]['id'],-1);
            echo $hash;
          }
      }  
   }
}
?>
