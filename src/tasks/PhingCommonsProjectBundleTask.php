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

        $includes = array();

        if(array_key_exists('include', $definition) && is_array($definition['include'])) {
            $includes = $definition['include'];
        }

        $excludes = array();

        if(array_key_exists('exclude', $definition) && is_array($definition['exclude'])) {
            $excludes = $definition['exclude'];
        }

        $files = array();
        $includes = $this->_getFiles($includes, 'includes');
        $excludes = $this->_getFiles($excludes, 'excludes');

        $files = array_diff($includes, $excludes);

        $this->log('');
        $this->log('copying');
        $this->log('- includes: ' . count($includes));
        $this->log('- excludes: ' . count($excludes));

        foreach($files as $file) {
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

            if($this->verbose) {
                $this->log('- ' . $destinationFile);
            }
        }

        $this->log('- copied  : ' . count($files));
    }

    /**
     * @param array $patternsets
     * @param $type
     * @return array
     */
    private function _getFiles(array $patternsets, $type) {
        $return = array();

        foreach($patternsets as $patternset) {
            $pattern = $this->projectRoot . '/' . $patternset;

            if($this->verbose) {
                $this->log('');
                $this->log("{$type}: {$pattern}");
            }

            if(strpos($pattern, '**') !== false) {
                $files = array_merge($this->_globRecursive($pattern));
            }
            elseif(strpos($pattern, '*') !== false) {
                $files = array_merge(glob($pattern));
            }
            else {
                $files[] = $pattern;
            }

            foreach($files as $file) {
                if(!is_dir($file) && !in_array($file, $return)) {
                    $return[] = $file;

                    if($this->verbose) {
                        $this->log('- ' . $file);
                    }
                }
            }
        }

        return $return;
    }

    /**
     * @param $pattern
     * @param int $flags
     * @return array
     */
    private function _globRecursive($pattern, $flags = 0) {
        $files = glob($pattern, $flags);

        foreach(glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->_globRecursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}