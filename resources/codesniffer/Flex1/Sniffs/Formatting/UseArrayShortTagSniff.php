<?php
namespace Flex1\Sniffs\Formatting;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Class UseArrayShortTagSniff
 */
class UseArrayShortTagSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [
            T_ARRAY,
        ];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $fix = $phpcsFile->addFixableError('Array short tag [ ... ] must be used', $stackPtr, 'NoShortTagUsed');

        if ($fix === true) {
            $tokens = $phpcsFile->getTokens();
            $token = $tokens[$stackPtr];

            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($stackPtr, '');
            $phpcsFile->fixer->replaceToken($token['parenthesis_opener'], '[');

            for ($i = ($stackPtr + 1); $i < $token['parenthesis_opener']; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }

            $phpcsFile->fixer->replaceToken($token['parenthesis_closer'], ']');
            $phpcsFile->fixer->endChangeset();
        }
    }
}
