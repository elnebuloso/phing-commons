<?php
require_once 'AbstractBundleTask.php';

/**
 * Class PhingCommonsBundleJSTask
 */
class PhingCommonsBundleJSTask extends AbstractBundleTask {

    /**
     * @var
     */
    protected $file;

    /**
     * @var
     */
    protected $public;

    /**
     * @var
     */
    protected $targetDir;

    /**
     * @var string
     */
    protected $java = 'java';

    /**
     * @param $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @param $public
     */
    public function setPublic($public) {
        $this->public = $public;
    }

    /**
     * @param $targetDir
     */
    public function setTargetDir($targetDir) {
        $this->targetDir = $targetDir;
    }

    /**
     * @param $java
     */
    public function setJava($java) {
        $this->java = $java;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();
    }
}