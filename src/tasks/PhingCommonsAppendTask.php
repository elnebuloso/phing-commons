<?php
require_once 'phing/Task.php';
require_once 'phing/types/FileList.php';
require_once 'phing/types/FileSet.php';

/**
 * Class PhingCommonsAppendTask
 */
class PhingCommonsAppendTask extends Task {

    /**
     * @var array
     */
    protected $filelists = array();

    /**
     * @var array
     */
    protected $filesets = array();

    /**
     * @var null
     */
    protected $destFile = null;

    /**
     * @var bool
     */
    protected $failonerror = false;

    /**
     * @return mixed
     */
    public function createFileList() {
        $num = array_push($this->filelists, new FileList());

        return $this->filelists[$num - 1];
    }

    /**
     * @return mixed
     */
    public function createFileSet() {
        $num = array_push($this->filesets, new FileSet());

        return $this->filesets[$num - 1];
    }

    /**
     * @param $value
     */
    public function setDestFile($value) {
        $this->destFile = $value;
    }

    /**
     * @param $value
     */
    public function setFailonerror($value) {
        $this->failonerror = $value;
    }

    /**
     * @throws BuildException|Exception
     */
    public function main() {
        foreach($this->filelists as $fl) {
            try {
                $files = $fl->getFiles($this->project);
                $fullPath = realpath($fl->getDir($this->project));

                if(file_exists($this->destFile)) {
                    $this->log('deleting old append file ' . $this->destFile);

                    if(!@unlink($this->destFile)) {
                        throw new BuildException('could not delete old append file');
                    }
                }

                foreach($files as $file) {
                    $this->log('Appending file ' . $file);

                    try {
                        $target = $this->destFile;

                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        if(strpos($file, 'http') === 0 || strpos($file, 'https') === 0) {
                            $content = file_get_contents($file);
                        }
                        else {
                            $content = file_get_contents($fullPath . '/' . $file);
                        }

                        $content .= PHP_EOL;
                        file_put_contents($target, $content, FILE_APPEND);
                    }
                    catch(Exception $e) {
                        $this->log("Could not append file $file: " . $e->getMessage(), Project::MSG_ERR);
                    }
                }
            }
            catch(BuildException $be) {
                if($this->failonerror) {
                    throw $be;
                }
                else {
                    $this->log($be->getMessage(), $this->quiet ? Project::MSG_VERBOSE : Project::MSG_WARN);
                }
            }
        }

        foreach($this->filesets as $fs) {
            try {
                $files = $fs->getDirectoryScanner($this->project)->getIncludedFiles();
                $fullPath = realpath($fs->getDir($this->project));

                if(file_exists($this->destFile)) {
                    $this->log('deleting old append file ' . $this->destFile);

                    if(!@unlink($this->destFile)) {
                        throw new BuildException('could not delete old append file');
                    }
                }

                foreach($files as $file) {
                    $this->log('Appending file ' . $file);

                    try {
                        $target = $this->destFile;

                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        if(strpos($file, 'http') === 0 || strpos($file, 'https') === 0) {
                            $content = file_get_contents($file);
                        }
                        else {
                            $content = file_get_contents($fullPath . '/' . $file);
                        }

                        $content .= PHP_EOL;
                        file_put_contents($target, $content, FILE_APPEND);
                    }
                    catch(Exception $e) {
                        $this->log("Could not append file $file: " . $e->getMessage(), Project::MSG_ERR);
                    }
                }
            }
            catch(BuildException $be) {
                if($this->failonerror) {
                    throw $be;
                }
                else {
                    $this->log($be->getMessage(), $this->quiet ? Project::MSG_VERBOSE : Project::MSG_WARN);
                }
            }
        }
    }
}