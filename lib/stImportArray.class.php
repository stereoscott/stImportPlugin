<?php

class stImportArray extends stImport
{
  protected
    $dataArray              = array(),
    $dataKeys               = array();
    
  public function getDataArray() 
  {
    return $this->dataArray;
  }

  public function setDataArray($v) 
  {
    $this->dataArray = $v;
  }
  
  public function getDataKeys() 
  {
    return $this->dataKeys;
  }

  public function setDataKeys($v) 
  {
    $this->dataKeys = $v;
  }
  
  public function process()
  {
    $numCols = count($this->getDataKeys());

    foreach($this->getDataArray() as $line) 
    {
      $numVals = count($line);
      if($numCols != $numVals) { 
        for($x = 0; $x < ($numCols - $numVals); $x++) {
          $line[] = '';
        }
      }

      $row = array_combine($this->getDataKeys(), $line);
      $row = array_map('trim', $row);
      
      $this->processRow($row);
    }
  }
  
}
