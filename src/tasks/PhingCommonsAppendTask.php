<?php
/**
 * @see phing/Task.php
 */
require_once 'phing/Task.php';

/**
 * @see phing/types/FileList.php
 */
require_once 'phing/types/FileList.php';

/**
 * @see phing/types/FileSet.php
 */
require_once 'phing/types/FileSet.php';

/**
 * Append (with external from url)
 *
 * @author Jan Thoennessen <jan.thoennessen@goolemail.com>
 */
class PhingCommonsAppendTask extends Task {

    /**
     * the source files
     *
     * @var FileList
     */
    protected $filelists = array();

    /**
     * the source files
     *
     * @var FileSet
     */
    protected $filesets = array();

    /**
     * Whether the build should fail, if errors occured
     *
     * @var boolean
     */
    protected $failonerror = false;

    /**
     * the path to the destination file
     *
     * @var string
     */
    protected $destFile = null;

    /**
     * Supports embedded <filelist> element.
     * @return FileList
     */
    public function createFileList() {
        $num = array_push($this->filelists, new FileList());
        return $this->filelists[$num - 1];
    }

    /**
     * Nested creator, adds a set of files (nested <fileset> attribute).
     * This is for when you don't care what order files get appended.
     * @return FileSet
     */
    public function createFileSet() {
        $num = array_push($this->filesets, new FileSet());
        return $this->filesets[$num - 1];
    }

    /**
     * Whether the build should fail, if an error occured.
     *
     * @param boolean $value
     */
    public function setFailonerror($value) {
        $this->failonerror = $value;
    }

    /**
     * the path to the destination file
     *
     * @param string $value
     */
    public function setDestFile($value) {
        $this->destFile = $value;
    }

    /**
     * The init method: Do init steps.
     */
    public function init() {
        return true;
    }

    /**
     * The main entry point method.
     */
    public function main() {
        // append any files in filelists
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
                // directory doesn't exist or is not readable
                if($this->failonerror) {
                    throw $be;
                }
                else {
                    $this->log($be->getMessage(), $this->quiet ? Project::MSG_VERBOSE : Project::MSG_WARN);
                }
            }
        }

        // append any files in filesets
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
                // directory doesn't exist or is not readable
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