<?php

class PermissionReader{

  public function getFilenames($dir = '.', $isFullPath = false){
    $dh = opendir($dir);

    $filenames = array();
    while(false !== ($fn = readdir($dh))){
      $fullPath = $dir.'/'.$fn;
      if($fn !== '.' && $fn !== '..' && !is_dir($fullPath)){
        array_push($filenames, $fullPath);
      }else if($fn !== '.' && $fn !== '..' && is_dir($fullPath)){
        array_push($filenames, $fullPath);
        $filenames = array_merge($filenames, $this->getFilenames($fullPath));
      }   
    }   
    closedir($dh);

    return $filenames;  
  }

  public function read($filenames){
    foreach($filenames as $filename){
      $results[] = array(
        'filename' => $filename,
        'permission' => sprintf('%o', fileperms($filename))
      );  
    }   
    return $results;
  }
}
