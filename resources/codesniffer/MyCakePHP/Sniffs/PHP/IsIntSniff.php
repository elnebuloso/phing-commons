<?php
/**
 * PHP Version 5
 *
 * MyCakePHP_Sniffs_PHP_IsIntSniff
 *
 * @category  PHP
 * @author    Mark Scherer <dereuromark@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   1.0
 */

/**
 * Ensures that short forms of is_*() are used if possible.
 *
 */
class MyCakePHP_Sniffs_PHP_IsIntSniff implements PHP_CodeSniffer_Sniff {

/**
 * Returns an array of tokens this test wants to listen for.
 *
 * @return array
 */
	public function register() {
		return array(T_STRING);
	}

/**
 * Processes this test, when one of its tokens is encountered.
 *
 * Ensures that short forms of is_*() are used if possible.
 * Also ensures casing.
 *
 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
 * @param integer              $stackPtr  The position of the current token in the
 *                                        stack passed in $tokens.
 * @return void
 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$content = strtolower($tokens[$stackPtr]['content']);
		if ($tokens[$stackPtr]['content'] === 'is_int') {
			return;
		}
		if ($content !== 'is_integer' && $content !== 'is_int') {
			return;
		}
		$nextToken = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
		if ($tokens[$nextToken]['code'] !== T_OPEN_PARENTHESIS) {
			return;
		}

		$error = 'Usage of ' . $tokens[$stackPtr]['content'] . ' not allowed; use short and lowercase form is_int() instead';
		$phpcsFile->addFixableError($error, $stackPtr, 'NotAllowed');

		// Fix the error
		if ($phpcsFile->fixer->enabled === true) {
			$phpcsFile->fixer->replaceToken($stackPtr, 'is_int');
		}
	}

}
