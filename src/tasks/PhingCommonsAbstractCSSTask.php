<?php
/**
 * @link http://code.google.com/p/cssmin/
 */
require_once dirname(__FILE__) . '/vendor/cssmin/CssMin.php';

/**
 * @link https://github.com/leafo/lessphp
 */
require_once dirname(__FILE__) . '/vendor/leafo/lessphp/lessc.inc.php';

/**
 * Class PhingCommonsAbstractCSSTask
 */
abstract class PhingCommonsAbstractCSSTask extends Task {

    /**
     * @var
     */
    protected $targetDir;

    /**
     * @var array
     */
    protected $cssFilters = array(
        'ImportImports' => false,
        // default false
        'ConvertLevel3Properties' => true
        // default true
    );

    /**
     * @var array
     */
    protected $cssPlugins = array(
        'Variables' => true,
        // default true
        'ConvertFontWeight' => true,
        // default false
        'ConvertNamedColors' => true,
        // default false
        'CompressColorValues' => true,
        // default false
        'CompressUnitValues' => false
        // default false
    );

    /**
     * @param $targetDir
     */
    public function setTargetDir($targetDir) {
        $this->targetDir = $targetDir;
    }

    /**
     * @param $value
     */
    public function setImportImports($value) {
        $this->cssFilters['ImportImports'] = array(
            'BasePath' => $value
        );
    }

    /**
     * @param $value
     */
    public function setConvertLevel3Properties($value) {
        $this->cssFilters['ConvertLevel3Properties'] = $value;
    }

    /**
     * @param $value
     */
    public function setVariables($value) {
        $this->cssPlugins['Variables'] = $value;
    }

    /**
     * @param $value
     */
    public function setConvertFontWeight($value) {
        $this->cssPlugins['ConvertFontWeight'] = $value;
    }

    /**
     * @param $value
     */
    public function setConvertNamedColors($value) {
        $this->cssPlugins['ConvertNamedColors'] = $value;
    }

    /**
     * @param $value
     */
    public function setCompressColorValues($value) {
        $this->cssPlugins['CompressColorValues'] = $value;
    }

    /**
     * @param $value
     */
    public function setCompressUnitValues($value) {
        $this->cssPlugins['CompressUnitValues'] = $value;
    }
}