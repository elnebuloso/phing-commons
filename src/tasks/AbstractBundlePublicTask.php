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
    protected $_targetDir;

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
     * @param $targetDir
     */
    public function setTargetDir($targetDir) {
        $this->_targetDir = $targetDir;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();

        $this->_targetDir = realpath($this->_targetDir);

        if($this->_targetDir === false) {
            throw new BuildException("Directory {$this->_targetDir} not found.");
        }

        $this->log("");
        $this->log("targetDir:  {$this->_targetDir}");
    }
} 