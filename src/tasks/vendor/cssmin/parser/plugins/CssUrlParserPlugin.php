<?php
/**
 * {@link aCssParserPlugin Parser plugin} for preserve parsing url() values.
 *
 * This plugin return no {@link aCssToken CssToken} but ensures that url() values will get parsed properly.
 *
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.1
 */
class CssUrlParserPlugin extends aCssParserPlugin {

    public static $isUrlSetActive = false;

    /**
     * Implements {@link aCssParserPlugin::getTriggerChars()}.
     *
     * @return array
     */
    public function getTriggerChars() {
        return array(
            "(",
            ")"
        );
    }

    /**
     * Implements {@link aCssParserPlugin::getTriggerStates()}.
     *
     * @return array
     */
    public function getTriggerStates() {
        return false;
    }

    /**
     * Implements {@link aCssParserPlugin::parse()}.
     *
     * @param integer $index Current index
     * @param string $char Current char
     * @param string $previousChar Previous char
     * @return mixed TRUE will break the processing; FALSE continue with the next plugin; integer set a new index and break the processing
     */
    public function parse($index, $char, $previousChar, $state) {
        if(in_array($state, array(
            'T_AT_IMPORT',
            'T_RULESET_DECLARATION'
        ))) {
            CssUrlParserPlugin::$isUrlSetActive = ($state === 'T_RULESET_DECLARATION') ? true : false;
        }

        // Start of string
        if($char === "(" && strtolower(substr($this->parser->getSource(), $index - 3, 4)) === "url(" && $state !== "T_URL") {
            $this->parser->pushState("T_URL");
            $this->parser->setExclusive(__CLASS__);
        }
        // Escaped LF in url => remove escape backslash and LF
        elseif($char === "\n" && $previousChar === "\\" && $state === "T_URL") {
            $this->parser->setBuffer(substr($this->parser->getBuffer(), 0, -2));
        }
        // Parse error: Unescaped LF in string literal
        elseif($char === "\n" && $previousChar !== "\\" && $state === "T_URL") {
            $line = $this->parser->getBuffer();
            $this->parser->setBuffer(substr($this->parser->getBuffer(), 0, -1) . ")"); // Replace the LF with the url string delimiter
            $this->parser->popState();
            $this->parser->unsetExclusive();
            CssMin::triggerError(new CssError(__FILE__, __LINE__, __METHOD__ . ": Unterminated string literal", $line . "_"));
        }
        // End of string
        elseif($char === ")" && $state === "T_URL") {

            if(CssUrlParserPlugin::$isUrlSetActive) {
                $value = $this->parser->getAndClearBuffer("");
                $value = preg_replace_callback('/url\((\'|")?(.+?)\1?\)/', array(
                    $this,
                    '_replaceUrl'
                ), $value);

                $this->parser->setBuffer($value);
                $this->parser->popState();
                $this->parser->unsetExclusive();
            }
            else {
                $this->parser->popState();
                $this->parser->unsetExclusive();
            }
        }
        else {
            return false;
        }
        return true;
    }

    public function _replaceUrl(array $m) {
        if(preg_match('/^(https?:\/\/|\/)/', $m[2], $x) || preg_match('/^data:/', $m[2], $x)) {
            return "url('{$m[2]}')";
        }

        $base  = explode('/', $this->configuration['BasePath']);
        $parts = explode('/', $m[2]);

        foreach($parts as $part) {
            if($part == '..') {
                if(!array_pop($base)) {
                    $base[] = '..';
                }
            }
            elseif($part != '.') {
                $base[] = $part;
            }
        }

        return "url('" . implode('/', $base) . "')";
    }
}