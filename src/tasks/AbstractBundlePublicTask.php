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
    protected $_public;

    /**
     * @var string
     */
    protected $_targetDir;

    /**
     * @var array
     */
    protected $_filesToUse;

    /**
     * @param $java
     */
    public function setJava($java) {
        $this->_java = $java;
    }

    /**
     * @param $public
     */
    public function setPublic($public) {
        $this->_public = $public;
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

        $this->_public = realpath($this->_public);
        $this->_targetDir = realpath($this->_targetDir);

        if($this->_public === false) {
            throw new BuildException("Directory {$this->_public} not found.");
        }

        if($this->_targetDir === false) {
            throw new BuildException("Directory {$this->_targetDir} not found.");
        }

        $this->log("");
        $this->log("public:     {$this->_public}");
        $this->log("targetDir:  {$this->_targetDir}");

        foreach($this->_manifestDefinition as $package => $definition) {
            $includes = array();
            $excludes = array();

            if(array_key_exists('include', $definition) && is_array($definition['include'])) {
                $includes = $definition['include'];
            }

            if(array_key_exists('exclude', $definition) && is_array($definition['exclude'])) {
                $excludes = $definition['exclude'];
            }

            $includeFiles = array();
            $excludeFiles = array();

            foreach($includes as $pattern) {
                $files = $this->_selectFiles($this->_public, '`' . $pattern . '`');
                $files = $this->_updateFiles($files);
                $includeFiles = array_merge($includeFiles, $files);
            }

            foreach($excludes as $pattern) {
                $files = $this->_selectFiles($this->_public, '`' . $pattern . '`');
                $files = $this->_updateFiles($files);
                $excludeFiles = array_merge($excludeFiles, $files);
            }

            if($this->_verbose) {
                $this->log("");
                $this->log("package: {$package}");

                foreach($includeFiles as $file) {
                    $this->log("include: {$file}");
                }
            }

            if($this->_verbose) {
                $this->log("");
                $this->log("package: {$package}");

                foreach($excludeFiles as $file) {
                    $this->log("exclude: {$file}");
                }
            }

            $this->_filesToUse[$package] = $this->_getFilesToUse($includeFiles, $excludeFiles);
        }
    }
} 