<?php

class stImport {
  
  protected 
    $delimiter              = ',',
    $rowCount               = 0,
    $dryRun                 = array(),
    $log                    = array(),
    $errors                 = array();
  
  /**
   * Constructor.
   *
   * @param boolean $dryRun If we should perform saves or not.
   */
  public function __construct($dryRun = true)
  {
    $this->setDryRun($dryRun);
  }
  
  /**
   * Sets the protected $dryRun var. Used to determine if we save to the DB.
   *
   * @param boolean $dryRun 
   * @return void
   */
  public function setDryRun($dryRun)
  {
    $this->dryRun = $dryRun;
  }
    
  public function setDelimiter($delimiter)
  {
    $this->delimiter = $delimiter;
  }
  

  public function process()
  {

  }
    
  protected function processRow($row)
  {
    
  }
    
  protected function addLogEntry($str, $error = 0)
  {
    $this->log[] = $str;
    if ($error) {
      $this->errors[] = $str;
    }
  }
  
  public function getLog()
  {
    return $this->log;
  }
  
  public function getErrors()
  {
    return $this->errors;
  }
  
  public function getRowCount()
  {
    return $this->rowCount;
  }
  
}