<?php
require_once 'AbstractBundleTask.php';

/**
 * Class PhingCommonsBundleProjectTask
 */
class PhingCommonsBundleProjectTask extends AbstractBundleTask {

    /**
     * @var string
     */
    protected $_buildProject;

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

        $this->_buildProject = realpath($this->_buildProject);

        if($this->_buildProject === false) {
            throw new BuildException("Directory {$this->_buildProject} not found.");
        }

        $this->log("");
        $this->log("buildProject:  {$this->_buildProject}");

        foreach($this->_filesSelected as $package => $data) {
            if($this->_verbose) {
                $this->log("");
                $this->log("package: {$package}");

                foreach($data['files'] as $file) {
                    $this->log("copy:   {$file}");

                    $destination = $this->_buildProject . '/' . $package . '/' . str_replace($this->_folder . '/', '', $file);
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
            $this->log("include: " . count($data['includes']));
            $this->log("exclude: " . count($data['excludes']));
            $this->log("copy:    " . count($data['files']));
        }
    }
}