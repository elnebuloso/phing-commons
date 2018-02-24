<?php

/**
 * MyCakePHP_Sniffs_Commenting_DocBlockEndingSniff.
 *
 * PHP version 5
 *
 * @author Mark Scherer
 * @license MIT
 */
class MyCakePHP_Sniffs_Commenting_DocBlockEndingSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(T_DOC_COMMENT);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token
	 *                                         in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();

		// We are only interested in function/class/interface doc block comments.
		$nextToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr + 1), null, true);
		$ignore = array(
			T_CLASS,
			T_INTERFACE,
			T_FUNCTION,
			T_PUBLIC,
			T_PRIVATE,
			T_PROTECTED,
			T_STATIC,
			T_ABSTRACT,
			);

		if (in_array($tokens[$nextToken]['code'], $ignore) === false) {
			// Could be a file comment.
			$prevToken = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr - 1), null, true);
			if ($tokens[$prevToken]['code'] !== T_OPEN_TAG) {
				return;
			}
		}

		// We only want to get the first comment in a block. If there is
		// a comment on the line before this one, return.
		$docComment = $phpcsFile->findPrevious(T_DOC_COMMENT, ($stackPtr - 1));
		if ($docComment !== false) {
			if ($tokens[$docComment]['line'] === ($tokens[$stackPtr]['line'] - 1)) {
				return;
			}
		}

		$comments = array($stackPtr);
		$currentComment = $stackPtr;
		$lastComment = $stackPtr;
		while (($currentComment = $phpcsFile->findNext(T_DOC_COMMENT, ($currentComment + 1))) !== false) {
			if ($tokens[$lastComment]['line'] === ($tokens[$currentComment]['line'] - 1)) {
				$comments[] = $currentComment;
				$lastComment = $currentComment;
			} else {
				break;
			}
		}

		// The $comments array now contains pointers to each token in the
		// comment block.
		$requiredColumn = strpos($tokens[$stackPtr]['content'], '*');
		$requiredColumn += $tokens[$stackPtr]['column'];

		foreach ($comments as $commentPointer) {
			// Check the spacing after each asterisk.
			$content = $tokens[$commentPointer]['content'];
			$firstChar = substr($content, 0, 1);
			$lastChar = substr($content, -1);
			if ($firstChar === '/' || $lastChar !== '/') {
				continue;
			}

			$count = substr_count($content, '*');
			if ($count < 2) {
				continue;
			}

			$error = 'Expected 1 asterisk on closing line; %s found';
			$data = array($count);
			$fix = $phpcsFile->addFixableError($error, $commentPointer, 'SpaceBeforeTag', $data);
			if ($fix === true && $phpcsFile->fixer->enabled === true) {
				$pos = strpos($content, '*');
				$content = substr($content, 0, $pos + 1) . substr($content, $pos + $count);
				$phpcsFile->fixer->replaceToken($commentPointer, $content);
			}
		}
	}

}
