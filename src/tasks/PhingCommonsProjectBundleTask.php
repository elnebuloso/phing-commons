<?php
/**
 * Class PhingCommonsProjectBundleTask
 */
class PhingCommonsProjectBundleTask extends Task {

    /**
     * @var
     */
    protected $manifest;

    /**
     * @var
     */
    protected $projectRoot;

    /**
     * @var
     */
    protected $buildProject;

    /**
     * @var
     */
    protected $verbose;

    /**
     * @param $manifest
     */
    public function setManifest($manifest) {
        $this->manifest = $manifest;
    }

    /**
     * @param $projectRoot
     */
    public function setProjectRoot($projectRoot) {
        $this->projectRoot = $projectRoot;
    }

    /**
     * @param $buildProject
     */
    public function setBuildProject($buildProject) {
        $this->buildProject = $buildProject;
    }

    /**
     * @param $verbose
     */
    public function setVerbose($verbose) {
        $this->verbose = $verbose;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        $manifest = realpath($this->manifest);
        $projectRoot = realpath($this->projectRoot);
        $buildProject = realpath($this->buildProject);

        $this->log('manifest:      ' . $manifest);
        $this->log('projectRoot:   ' . $projectRoot);
        $this->log('buildProject:  ' . $buildProject);

        if($manifest === false) {
            throw new BuildException("Manifest file {$manifest} not found.");
        }

        if($projectRoot === false) {
            throw new BuildException("Directory {$projectRoot} not found.");
        }

        if($buildProject === false) {
            throw new BuildException("Directory {$buildProject} not found.");
        }

        $definition = json_decode(file_get_contents($this->manifest), true);

        // patterns to include
        $includes = array();

        if(array_key_exists('include', $definition) && is_array($definition['include'])) {
            $includes = $definition['include'];
        }

        // patterns to exclude
        $excludes = array();

        if(array_key_exists('exclude', $definition) && is_array($definition['exclude'])) {
            $excludes = $definition['exclude'];
        }

        // files to include
        $includeFiles = array();

        foreach($includes as $pattern) {
            $files = $this->_searchFiles($projectRoot, '`' . $pattern . '`');
            $files = $this->_updateFiles($files);

            $includeFiles = array_merge($includeFiles, $files);
        }

        // files to exclude
        $excludeFiles = array();

        foreach($excludes as $pattern) {
            $files = $this->_searchFiles($projectRoot, '`' . $pattern . '`');
            $files = $this->_updateFiles($files);

            $excludeFiles = array_merge($excludeFiles, $files);
        }

        if($this->verbose) {
            $this->log('');

            foreach($includeFiles as $file) {
                $this->log('- include: ' . $file);
            }
        }

        if($this->verbose) {
            $this->log('');

            foreach($excludeFiles as $file) {
                $this->log('- exclude: ' . $file);
            }
        }

        $filesToCopy = array_diff($includeFiles, $excludeFiles);

        if($this->verbose) {
            $this->log('');

            foreach($filesToCopy as $file) {
                $this->log('- copy: ' . $file);

                $sourceFile = $file;
                $destinationFile = $buildProject . '/' . str_replace($projectRoot . '/', '', $file);
                $directory = dirname($destinationFile);

                if(!file_exists($directory)) {
                    if(!mkdir($directory, 0755, true)) {
                        throw new BuildException("Unable to create {$directory}");
                    }
                }

                if(!copy($sourceFile, $destinationFile)) {
                    throw new BuildException("Unable to create {$destinationFile}");
                }
            }
        }

        $this->log('');
        $this->log('include Files: ' . count($includeFiles));
        $this->log('exclude Files: ' . count($excludeFiles));
        $this->log('copied Files:  ' . count($filesToCopy));
    }

    /**
     * @param string $folder
     * @param string $pattern
     * @return array
     */
    private function _searchFiles($folder, $pattern) {
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
    private function _updateFiles(array $fileList) {
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
}