<?php

/**
 * PHP version 5
 *
 * @author    Mark Scherer
 * @license   MIT
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractScopeSniff', true) === false) {
	$error = 'Class PHP_CodeSniffer_Standards_AbstractScopeSniff not found';
	throw new PHP_CodeSniffer_Exception($error);
}

/**
 * Verifies that a @return tag exists for all functions and methods and that it does not exist
 * for all constructors and deconstructors.
 *
 * @author    Mark Scherer
 * @license   MIT
 */
class MyCakePHP_Sniffs_Commenting_ReturnTagSniff extends PHP_CodeSniffer_Standards_AbstractScopeSniff {

	/**
	 * Constructs a MyCakePHP_Sniffs_Commenting_ReturnTagSniff.
	 */
	public function __construct() {
		parent::__construct(array(T_CLASS), array(T_FUNCTION));
	}

	/**
	 * Processes the function tokens within the class.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file where this token was found.
	 * @param int                  $stackPtr  The position where the token was found.
	 * @param int                  $currScope The current scope opener token.
	 *
	 * @return void
	 */
	protected function processTokenWithinScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $currScope) {
		$tokens = $phpcsFile->getTokens();

		// Type of method
		$method = $phpcsFile->findNext(T_STRING, ($stackPtr + 1));
		$returnRequired = !in_array($tokens[$method]['content'], array('__construct', '__destruct'));

		$find = array(
			T_COMMENT,
			T_DOC_COMMENT,
			T_CLASS,
			T_FUNCTION,
			T_OPEN_TAG,
		);

		$commentEnd = $phpcsFile->findPrevious($find, ($stackPtr - 1));

		if ($commentEnd === false) {
			return;
		}

		if ($tokens[$commentEnd]['code'] !== T_DOC_COMMENT) {
			// Function doesn't have a comment. Let someone else warn about that.
			return;
		}

		$commentStart = ($phpcsFile->findPrevious(T_DOC_COMMENT, ($commentEnd - 1), null, true) + 1);

		//$comment = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));
		$commentWithReturn = null;
		for ($i = $commentEnd; $i >= $commentStart; $i--) {
			$currentComment = $tokens[$i]['content'];
			if (strpos($currentComment, '@return ') !== false) {
				$commentWithReturn = $i;
				break;
			}
		}

		if (!$commentWithReturn && !$returnRequired) {
			return;
		}

		if ($commentWithReturn && $returnRequired) {
			return;
		}

		// A class method should have @return
		if (!$commentWithReturn) {
			$error = 'Missing @return tag in function comment';
			$phpcsFile->addError($error, $stackPtr, 'Missing');
			return;
		}

		// Constructor/deconstructor should not have @return
		if ($commentWithReturn) {
			$error = 'Unexpected @return tag in constructor/deconstructor comment';
			$phpcsFile->addFixableError($error, $commentWithReturn, 'Unexpected');
			if ($phpcsFile->fixer->enabled === true) {
				$phpcsFile->fixer->replaceToken($commentWithReturn, '');
			}
			return;
		}
	}

}
