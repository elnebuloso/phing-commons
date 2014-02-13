<?php
require_once 'AbstractBundleTask.php';

/**
 * Class AbstractBundlePublicTask
 *
 * @package PhingCommons\Bundle
 * @author Jan Thönneßen <jan.thoennessen@googlemail.com>
 */
abstract class AbstractBundlePublicTask extends AbstractBundleTask {

    /**
     * @var string
     */
    protected $_target;

    /**
     * @var string
     */
    protected $_java = 'java';

    /**
     * @var string
     */
    protected $_compiler = 'yuicompressor';

    /**
     * @var string
     */
    protected $_content;

    /**
     * @var string
     */
    protected $_destinationMax;

    /**
     * @var string
     */
    protected $_destinationMin;

    /**
     * @param $target
     */
    public function setTarget($target) {
        $this->_target = $target;
    }

    /**
     * @param $java
     */
    public function setJava($java) {
        $this->_java = $java;
    }

    /**
     * @param $compiler
     */
    public function setCompiler($compiler) {
        $this->_compiler = $compiler;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();
    }

    /**
     * @param string $path
     * @param string $from
     * @return string
     */
    protected function _getRelativePath($path, $from) {
        $path = explode(DIRECTORY_SEPARATOR, $path);
        $from = rtrim($from, '/') . '/';
        $from = explode(DIRECTORY_SEPARATOR, dirname($from . '.'));
        $common = array_intersect_assoc($path, $from);

        $base = array('.');
        if($pre_fill = count(array_diff_assoc($from, $common))) {
            $base = array_fill(0, $pre_fill, '..');
        }
        $path = array_merge($base, array_diff_assoc($path, $common));

        return implode(DIRECTORY_SEPARATOR, $path);
    }
}