<?php

class stImportCsvToYaml extends stImportCSV
{
  protected 
    $csvArray,
    $model,
    $prefix,
    $defaultValues;
  
  public function setModel($model)
  {
    $this->model = $model;
  }
  
  public function setPrefix($prefix)
  {
    $this->prefix = $prefix;
  }
    
  public function toYaml()
  {
    return sfYaml::dump($this->csvArray, 3);
  }
  
  public function setDefaultValues($defaults)
  {
    $this->defaultValues = $defaults;
  }
  
  protected function processRow($row)
  {
    static $i = 1;

    if (!empty($this->defaultValues)) {
      $row = array_merge($this->defaultValues, $row);
    }
    
    $this->csvArray[$this->model][$this->prefix.$this->model.'_'.$i] = $row;
    
    $i++;
  }
  
} 

?>