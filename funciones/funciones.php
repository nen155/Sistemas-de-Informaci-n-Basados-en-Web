<?php
function suma($a, $b){
    return ($a + $b);
}

function resta($a, $b){
    return ($a - $b);
}

function validarParametro($a)
{
    return isset($a) && !empty($a);
}

function validarNombre($nombre,$longitud){ 
   //compruebo que el tamaño del string sea válido. 
   if (strlen($nombre)<3 || strlen($nombre)>$longitud){ 
      return false; 
   } 
   //compruebo que los caracteres sean los permitidos 
   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_"; 
   for ($i=0; $i<strlen($nombre); $i++){ 
      if (strpos($permitidos, substr($nombre,$i,1))===false){  
         return false; 
      } 
   } 
   return true; 
} 

function validarParametroEntero($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_INT);
}

function validarCorreo($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_EMAIL);
}

function validarParametroBoolean($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_BOOLEAN);
}

function validarParametroFloat($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_FLOAT);
}

function validarParametroUrl($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_URL);
}

function validarParametroIp($a){
   return isset($a) && !empty($a) &&
        filter_var ($a, FILTER_VALIDATE_IP);
}
?>
