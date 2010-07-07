<?php

class stImportCSV extends stImport 
{
  protected 
    $file,
    $legend                 = array();
  
  
  public function setLegend($newLegend)
  {
    $this->legend = array_merge($this->legend, $newLegend);
  }
  
  protected function applyLegend($row)
  {
    $data = array();
    foreach ($this->legend as $csvKey => $internalKey)
    {
      $data[$internalKey] = isset($row[$csvKey]) ? $row[$csvKey] : null;
    }
    
    unset($internalKey, $csvKey, $row);
    
    return $data;
  }
    
  public function setFile($file)
  {
    $this->file = $file;
  }
  
  public function process()
  {
    ini_set('auto_detect_line_endings', true);
    
    $csvFile = fopen($this->file, 'r');
    $csvKeys = fgetcsv($csvFile, 1000, $this->delimiter); // first line of the csv file has the column descriptions
    $numCols = count($csvKeys);
        
    while($line = fgetcsv($csvFile, 1000, $this->delimiter)) 
    {
      $numVals = count($line); //fill out empty columns.. pretend there are 13 keys, 9 values...
      if($numCols != $numVals) { 
        if ($numCols > $numVals) {
          $line = array_pad($line, $numCols, '');
        } else {
          $csvKeys = array_pad($csvKeys, $numVals, '');
          $numCols = count($csvKeys);
        }
      }
      
      $row = array_combine($csvKeys, $line);
      $row = array_map('trim', $row);
      
      $this->processRow($row);
      unset($row, $line, $numVals);
    }

  }
  
  
}