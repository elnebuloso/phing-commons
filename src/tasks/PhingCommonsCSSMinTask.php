<?php
require_once 'PhingCommonsAbstractCSSTask.php';
require_once 'phing/types/FileList.php';
require_once 'phing/types/FileSet.php';

/**
 * Class PhingCommonsCSSMinTask
 */
class PhingCommonsCSSMinTask extends PhingCommonsAbstractCSSTask {

    /**
     * @var array
     */
    protected $filelists = array();

    /**
     * @var array
     */
    protected $filesets = array();

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
    public function setFailonerror($value) {
        $this->failonerror = $value;
    }

    /**
     * @throws BuildException|Exception
     */
    public function main() {
        parent::main();

        foreach($this->filelists as $fl) {
            try {
                $files = $fl->getFiles($this->project);
                $fullPath = realpath($fl->getDir($this->project));

                foreach($files as $file) {
                    $this->log('Minifying file ' . $file);

                    try {
                        $target = $this->targetDir . '/' . str_replace($fullPath, '', str_replace(".css", ".min.css", $file));

                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        $content = file_get_contents($fullPath . '/' . $file);

                        if($content === false) {
                            throw new BuildException('- Unable to get content from file: ' . $fullPath . '/' . $file);
                        }

                        $minifier = new CssMinifier($content, $this->cssFilters, $this->cssPlugins);

                        file_put_contents($target, $minifier->getMinified());
                    }
                    catch(Exception $e) {
                        $this->log("Could not minify file $file: " . $e->getMessage(), Project::MSG_ERR);
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

                foreach($files as $file) {
                    $this->log('Minifying file ' . $file);

                    try {
                        $target = $this->targetDir . '/' . str_replace($fullPath, '', str_replace(".css", ".min.css", $file));

                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        $content = file_get_contents($fullPath . '/' . $file);

                        if($content === false) {
                            throw new BuildException('- Unable to get content from file: ' . $fullPath . '/' . $file);
                        }

                        $minifier = new CssMinifier($content, $this->cssFilters, $this->cssPlugins);

                        file_put_contents($target, $minifier->getMinified());
                    }
                    catch(Exception $e) {
                        $this->log("Could not minify file $file: " . $e->getMessage(), Project::MSG_ERR);
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