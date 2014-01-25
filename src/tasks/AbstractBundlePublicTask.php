<?php
require_once 'AbstractBundleTask.php';

/**
 * Class AbstractBundlePublicTask
 */
abstract class AbstractBundlePublicTask extends AbstractBundleTask {

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
} 