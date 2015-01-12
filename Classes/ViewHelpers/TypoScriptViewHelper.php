<?php
namespace Moc\MocHelpers\ViewHelpers;
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
class TypoScriptViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {


  /**
   * Parses a block of typoscript and renders the output
   *
   * @return string
   * @author Mads Brunn <mads@brunn.dk>
   */
  function render(){

    $setup = $this->renderChildren();
    $tsparser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser');
    $tsparser->parse($setup);
    $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
    return $cObj->cObjGet($tsparser->setup);

  }

}



?>
