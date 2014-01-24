<?php
/**
 * Class AbstractBundleTask
 */
abstract class AbstractBundleTask extends Task {

    /**
     * @var string
     */
    protected $_manifest;

    /**
     * @var array
     */
    protected $_manifestDefinition;

    /**
     * @var int
     */
    protected $_verbose;

    /**
     * @param string $manifest
     */
    public function setManifest($manifest) {
        $this->_manifest = $manifest;
    }

    /**
     * @param $verbose
     */
    public function setVerbose($verbose) {
        $this->_verbose = (int) $verbose;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        $this->_manifest = realpath($this->_manifest);

        if($this->_manifest === false) {
            throw new BuildException("Manifest file {$this->_manifest} not found.");
        }

        $this->log('manifest:  ' . $this->_manifest);
        $this->_readManifest();
    }

    /**
     * @return void
     */
    protected function _readManifest() {
        $this->_manifestDefinition = json_decode(file_get_contents($this->_manifest), true);

        if($this->_verbose) {
            foreach($this->_manifestDefinition as $package => $definition) {
                $this->log("");
                $this->log('package: ' . $package);

                foreach($definition as $type => $patternset) {
                    foreach($patternset as $pattern) {
                        $this->log("{$type}: {$pattern}");
                    }
                }
            }
        }
    }

    /**
     * @param string $folder
     * @param string $pattern
     * @return array
     */
    protected function _selectFiles($folder, $pattern) {
        $dir = new RecursiveDirectoryIterator($folder);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = array();

        foreach($files as $file) {
            $fileList = array_merge($fileList, $file);
        }

        return $fileList;
    }

    /**
     * @param array $fileList
     * @return array
     */
    protected function _updateFiles(array $fileList) {
        $returnFiles = array();

        foreach($fileList as $currentFile) {
            $currentFile = realpath($currentFile);

            if(empty($currentFile) || is_dir($currentFile)) {
                continue;
            }

            $returnFiles[$currentFile] = $currentFile;
        }

        return $returnFiles;
    }

    /**
     * @param array $includeFiles
     * @param array $excludeFiles
     * @return array
     */
    protected function _getFilesToUse(array $includeFiles, array $excludeFiles) {
        return array_diff($includeFiles, $excludeFiles);
    }
}