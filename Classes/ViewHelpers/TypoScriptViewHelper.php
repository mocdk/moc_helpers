<?php
/**
 * TypoScript ViewHelper for fluid 
 * Parses content as typoscript and returns the result
 *
 * Example:
 *    {namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *    <moc:TypoScript>
 *
 *      10 = TEXT
 *      10.value = Hello World!
 *
 *    </moc:TypoScript>
 *
 */
class Tx_MocHelpers_ViewHelpers_TypoScriptViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

  
  /**
   * Parses a block of typoscript and renders the output
   *
   * @return string 
   * @author Mads Brunn <mads@brunn.dk>
   */  
  function render(){
    
    $setup = $this->renderChildren();
    $tsparser = t3lib_div::makeInstance('t3lib_TSparser');
    $tsparser->parse($setup);
    $cObj = t3lib_div::makeInstance('tslib_cObj');
    return $cObj->cObjGet($tsparser->setup);
    
  }

}



?>
