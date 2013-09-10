<?php
require_once 'PhingCommonsJSMinTask.php';

/**
 * Class PhingCommonsJSBundleTask
 */
class PhingCommonsJSBundleTask extends PhingCommonsJSMinTask {

    /**
     * @var
     */
    protected $file;

    /**
     * @var
     */
    protected $public;

    /**
     * @var array
     */
    private $_cachebuster = array();

    /**
     * @param $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @param $public
     */
    public function setPublic($public) {
        $this->public = $public;
    }

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();

        $pathFile = realpath($this->file);
        $pathPublic = realpath($this->public);

        $this->log('manifest: ' . $pathFile);
        $this->log('public:   ' . $pathPublic);

        if($pathFile === false) {
            throw new BuildException("Manifest file {$pathFile} not found.");
        }

        if($pathPublic === false) {
            throw new BuildException("Public directory {$pathPublic} not found.");
        }

        $cwd = getcwd();

        // change to public path to resolve stylesheets relative
        chdir($pathPublic);

        $packages = json_decode(file_get_contents($this->file), true);

        foreach($packages as $package => $files) {
            $this->log('processing package ' . $package);

            // content of files per package
            $content = array();

            foreach($files as $file) {
                $this->log('- importing file ' . $file);
                $content[] = file_get_contents($file);
            }

            $content = implode(PHP_EOL, $content);

            // debug
            $target = "{$pathPublic}/{$package}.js";
            file_put_contents($target, $content);
            $this->log('- written ' . $target);

            // cachebuster files production debug
            $md5 = md5(file_get_contents($target));
            $this->_cachebuster[$package]['debug'] = "{$package}.js?version={$md5}";

            // minified
            $content = $this->compile($content);
            $target = "{$pathPublic}/{$package}.min.js";
            file_put_contents($target, $content);
            $this->log('- written ' . $target);

            // cachebuster files production min
            $md5 = md5(file_get_contents($target));
            $this->_cachebuster[$package]['min'] = "{$package}.min.js?version={$md5}";
        }

        // write cachebuster file
        $cachebuster = dirname($this->file) . '/js.php';
        @unlink($cachebuster);
        file_put_contents($cachebuster, '<?php return ' . var_export($this->_cachebuster, true) . ';');
        $this->log('- written ' . $cachebuster);

        // change back to baseDir
        chdir($cwd);
    }
}