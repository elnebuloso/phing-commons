<?php
require_once 'AbstractBundleTask.php';

/**
 * Class PhingCommonsBundleProjectTask
 */
class PhingCommonsBundleProjectTask extends AbstractBundleTask {

    /**
     * @var string
     */
    protected $_projectRoot;

    /**
     * @var string
     */
    protected $_buildProject;

    /**
     * @param $projectRoot
     */
    public function setProjectRoot($projectRoot) {
        $this->_projectRoot = $projectRoot;
    }

    /**
     * @param $buildProject
     */
    public function setBuildProject($buildProject) {
        $this->_buildProject = $buildProject;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();

        $this->_projectRoot = realpath($this->_projectRoot);
        $this->_buildProject = realpath($this->_buildProject);

        if($this->_projectRoot === false) {
            throw new BuildException("Directory {$this->_projectRoot} not found.");
        }

        if($this->_buildProject === false) {
            throw new BuildException("Directory {$this->_buildProject} not found.");
        }

        $this->log("");
        $this->log("projectRoot:   {$this->_projectRoot}");
        $this->log("buildProject:  {$this->_buildProject}");

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
                $files = $this->_selectFiles($this->_projectRoot, '`' . $pattern . '`');
                $files = $this->_updateFiles($files);
                $includeFiles = array_merge($includeFiles, $files);
            }

            foreach($excludes as $pattern) {
                $files = $this->_selectFiles($this->_projectRoot, '`' . $pattern . '`');
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

            $filesToUse = $this->_getFilesToUse($includeFiles, $excludeFiles);

            if($this->_verbose) {
                $this->log("");
                $this->log("package: {$package}");

                foreach($filesToUse as $file) {
                    $this->log("copy:   {$file}");

                    $destination = $this->_buildProject . '/' . $package . '/' . str_replace($this->_projectRoot . '/', '', $file);
                    $directory = dirname($destination);

                    if(!file_exists($directory)) {
                        if(!mkdir($directory, 0755, true)) {
                            throw new BuildException("Unable to create {$directory}");
                        }
                    }

                    if(!copy($file, $destination)) {
                        throw new BuildException("Unable to create {$destination}");
                    }
                }
            }

            $this->log("");
            $this->log("package: {$package}");
            $this->log("include: " . count($includeFiles));
            $this->log("exclude: " . count($excludeFiles));
            $this->log("copy:    " . count($filesToUse));
        }

        return;
    }
}