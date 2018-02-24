<?php
if (!defined('WINDOWS')) {
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		define('WINDOWS', true);
	} else {
		define('WINDOWS', false);
	}
}

/**
 * CakePHP_Sniffs_Files_LineEndingsSniff
 *
 * PHP version 5
 *
 * @category  PHP
 * @author    Mark Scherer <dereuromark@gmail.com>
 * @copyright Copyright 2005-2013, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   1.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer_CakePHP
 */
class MyCakePHP_Sniffs_Files_LineEndingsSniff extends Generic_Sniffs_Files_LineEndingsSniff {

	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		if (WINDOWS) {
			$this->eolChar = "\r\n";
		}
	}

}