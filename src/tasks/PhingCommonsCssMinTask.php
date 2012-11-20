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
 * @link http://code.google.com/p/cssmin/
 */
require_once 'vendor/cssmin-v3.0.1.php';

/**
 * CSS Minify Task
 *
 * @author  Jan Thoennessen <jan.thoennessen@googlemail.com>
 */
class PhingCommonsCssMinTask extends Task {

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
     * Whether the build should fail, if
     * errors occured
     *
     * @var boolean
     */
    protected $failonerror = false;

    /**
     * Define if the target should use or not a suffix -min
     *
     * @var boolean
     */
    protected $suffix = '-min';

    /**
     * directory to put minified javascript files into
     *
     * @var  string
     */
    protected $targetDir;

    /**
     * the css filtes to use
     *
     * @var array
     */
    protected $cssFilters = array(
        'ImportImports' => false,  // default false
        'ConvertLevel3Properties' => true // default true
    );

    /**
     * the css plugins to use
     *
     * @var array
     */
    protected $cssPlugins = array(
        'Variables' => true,  // default true
        'ConvertFontWeight' => true,  // default false
        'ConvertNamedColors' => true,  // default false
        'CompressColorValues' => true,  // default false
        'CompressUnitValues' => true // default false
    );

    /**
     * set filter
     *
     * @param string $value
     */
    public function setImportImports($value) {
        $this->cssFilters['ImportImports'] = array(
            'BasePath' => $value
        );
    }

    /**
     * set filter
     *
     * @param bool $value
     */
    public function setConvertLevel3Properties($value) {
        $this->cssFilters['ConvertLevel3Properties'] = $value;
    }

    /**
     * set plugin
     *
     * @param bool $value
     */
    public function setVariables($value) {
        $this->cssPlugins['Variables'] = $value;
    }

    /**
     * set plugin
     *
     * @param bool $value
     */
    public function setConvertFontWeight($value) {
        $this->cssPlugins['ConvertFontWeight'] = $value;
    }

    /**
     * set plugin
     *
     * @param bool $value
     */
    public function setConvertNamedColors($value) {
        $this->cssPlugins['ConvertNamedColors'] = $value;
    }

    /**
     * set plugin
     *
     * @param bool $value
     */
    public function setCompressColorValues($value) {
        $this->cssPlugins['CompressColorValues'] = $value;
    }

    /**
     * set plugin
     *
     * @param bool $value
     */
    public function setCompressUnitValues($value) {
        $this->cssPlugins['CompressUnitValues'] = $value;
    }

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
     * Define if the task should or not use a suffix (-min is the default)
     *
     * @param string $value
     */
    public function setSuffix($value) {
        $this->suffix = $value;
    }

    /**
     * sets the directory where minified javascript files should be put inot
     *
     * @param  string  $targetDir
     */
    public function setTargetDir($targetDir) {
        $this->targetDir = $targetDir;
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
        // minify any files in filelists
        foreach($this->filelists as $fl) {
            try {
                $files = $fl->getFiles($this->project);
                $fullPath = realpath($fl->getDir($this->project));

                foreach($files as $file) {
                    $this->log('Minifying file ' . $file);

                    try {
                        $target = $this->targetDir . '/' . str_replace($fullPath, '', str_replace('.css', $this->suffix . '.css', $file));
                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        $content = file_get_contents($fullPath . '/' . $file);
                        $minifier = new CssMinifier($content, $this->cssFilters, $this->cssPlugins);

                        file_put_contents($target, $minifier->getMinified());
                    }
                    catch(Exception $e) {
                        $this->log("Could not minify file $file: " . $e->getMessage(), Project::MSG_ERR);
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

        // minify any files in filesets
        foreach($this->filesets as $fs) {
            try {
                $files = $fs->getDirectoryScanner($this->project)->getIncludedFiles();
                $fullPath = realpath($fs->getDir($this->project));

                foreach($files as $file) {
                    $this->log('Minifying file ' . $file);

                    try {
                        $target = $this->targetDir . '/' . str_replace($fullPath, '', str_replace('.css', $this->suffix . '.css', $file));
                        if(file_exists(dirname($target)) === false) {
                            mkdir(dirname($target), 0700, true);
                        }

                        $content = file_get_contents($fullPath . '/' . $file);
                        $minifier = new CssMinifier($content, $this->cssFilters, $this->cssPlugins);

                        file_put_contents($target, $minifier->getMinified());
                    }
                    catch(Exception $e) {
                        $this->log("Could not minify file $file: " . $e->getMessage(), Project::MSG_ERR);
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