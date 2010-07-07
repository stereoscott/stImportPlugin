<?php

class stImport {
  
  protected 
    $delimiter              = ',',
    $dryRun                 = array(),
    $log                    = array();
  
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
    
  protected function addLogEntry($str)
  {
    $this->log[] = $str;
  }
  
  public function getLog()
  {
    return $this->log;
  }
  
}