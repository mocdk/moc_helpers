<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * Class IsLoggedInViewHelper
 */
class IsLoggedInViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {

	/**
	 * Check if a a user whith a specific id is logged in
	 *
	 * @param int $userId UserId to check against
	 * @return boolean TRUE if user is logged in, FALSE if no
	 */
	public function render($userId) {
		return ((intval($GLOBALS['TSFE']->fe_user->user['uid']) > 0) && (intval($GLOBALS['TSFE']->fe_user->user['uid']) === intval($userId)));
	}

}