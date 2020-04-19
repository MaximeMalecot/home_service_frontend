<?php
  function prepareQuery($arrayData, $QueryStart, $type, $QueryEnd){
    $nbArgs = count($arrayData);
    $prepareStringReq = $QueryStart;
    $i =0;
    while($i < $nbArgs){
      if($type != null){
        if($i===0){
          $prepareStringReq = $prepareStringReq.$type."(?)";
        }
        else{
          $prepareStringReq = $prepareStringReq.", ".$type."(?)";
        }
        $i+=1;
      }
      else{
        if($i===0){
          $prepareStringReq = $prepareStringReq."?";
        }
        else{
          $prepareStringReq = $prepareStringReq.", ?";
        }
        $i+=1;
      }
    }
    $prepareStringReq = $prepareStringReq.$QueryEnd;
    return $prepareStringReq;
  }

?>
