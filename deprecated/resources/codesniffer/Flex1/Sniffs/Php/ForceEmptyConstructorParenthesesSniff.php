<?php
namespace Flex1\Sniffs\Php;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Class ForceEmptyConstructorParenthesesSniff
 */
class ForceEmptyConstructorParenthesesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [
            T_NEW,
        ];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->getTokens();

        $end = $phpcsFile->findNext([
            T_CLOSE_PARENTHESIS,
            T_COMMA,
            T_SEMICOLON,
        ], $stackPtr);

        $hasParentheses = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr, $end);

        if (!$hasParentheses) {
            $fix = $phpcsFile->addFixableError('There must be parentheses after constructor call.', $stackPtr);

            if ($fix) {
                $phpcsFile->fixer->beginChangeset();
                $phpcsFile->fixer->addContentBefore($end, '()');
                $phpcsFile->fixer->endChangeset();
            }
        }
    }
}
