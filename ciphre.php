<?php
function ciphre($logo,$mode){
    $sec='KrY84yvD69cJBNX8IVwZ9UYN8si9Mmu436e0RLQHu2KiNGV5k5';
    $dobh=bin2hex($sec);
    $password = hex2bin($dobh);
    $cript='';
  if($mode==1){
    $cript=openssl_encrypt($logo,"AES-128-ECB",$password);
  }
  if($mode==-1){
    $cript=openssl_decrypt($logo,"AES-128-ECB",$password);
  }
  return $cript;
}
?>