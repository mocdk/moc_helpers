<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
function localizeTable($tableName){
  global $TCA;
  $TCA[$tableName]['columns']['sys_language_uid'] = Array (
    'exclude' => 1,
    'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
    'config' => Array (
      'type' => 'select',
      'foreign_table' => 'sys_language',
      'foreign_table_where' => 'ORDER BY sys_language.title',
      'items' => Array(
        Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
        Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
                       )
                       )
                                                                                    );

  $TCA[$tableName]['columns']['l18n_parent'] = Array (
    'displayCond' => 'FIELD:sys_language_uid:>:0',
    'exclude' => 1,
    'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
    'config' => Array (
      'type' => 'group',
      'internal_type' => 'db',
      'allowed' => $tableName,
      'items' => Array (
        Array('', 0),
                        ),
      'foreign_table' => $tableName,
      'foreign_table_where' => 'AND '.$tableName.'.pid=###CURRENT_PID### AND '.$tableName.'.sys_language_uid IN (-1,0)',
                       )
                                                                               );

  $TCA[$tableName]['columns']['l18n_diffsource'] = array(
    'config' => array(
      'type' => 'passthrough'
                      )
                                                                                  );

  $TCA[$tableName]['interface']['showRecordFieldList'] = 'sys_language_uid,l18n_parent,l18n_diffsource,'.$TCA[$tableName]['interface']['showRecordFieldList'];
  $TCA[$tableName]['types'][1]['showitem'] = 'sys_language_uid,l18n_parent,l18n_diffsource,'.$TCA[$tableName]['types'][1]['showitem'];

  $TCA[$tableName]['ctrl']['languageField'] = 'sys_language_uid';
  $TCA[$tableName]['ctrl']['transOrigPointerField'] = 'l18n_parent';
  $TCA[$tableName]['ctrl']['transOrigDiffSourceField'] = 'l18n_diffsource';
}
