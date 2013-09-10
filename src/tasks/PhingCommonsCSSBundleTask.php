<?php
require_once 'PhingCommonsCSSMinTask.php';

/**
 * Class PhingCommonsCSSBundleTask
 */
class PhingCommonsCSSBundleTask extends PhingCommonsCSSMinTask {

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
        $less = new lessc();

        $this->cssFilters = array_merge($this->cssFilters, array(
            'ImportImports' => array(
                'BasePath' => '.'
            )
        ));

        // change to public path to resolve stylesheets relative
        chdir($pathPublic);

        $packages = json_decode(file_get_contents($this->file), true);

        foreach($packages as $package => $files) {
            $this->log('processing package ' . $package);

            $content = array();

            foreach($files as $file) {
                if(pathinfo($file, PATHINFO_EXTENSION) === 'less') {
                    $this->log('- compiling file ' . $file);
                    $content[] = $less->compileFile($file);
                    continue;
                }

                $this->log('- importing file ' . $file);
                $content[] = "@import url('{$file}');";
            }

            $content = implode(PHP_EOL, $content);

            // debug
            $cssFilter = array_merge($this->cssFilters, array(
                'RemoveComments' => false,
                'RemoveEmptyRulesets' => false,
                'RemoveEmptyAtBlocks' => false
            ));

            $cssPlugins = array_merge($this->cssPlugins, array());
            $target = "{$pathPublic}/{$package}.css";
            $minifier = new CssMinifier($content, $cssFilter, $cssPlugins, false);
            file_put_contents($target, $minifier->getMinified());
            $this->log('- written ' . $target);

            // cachebuster files production debug
            $md5 = md5(file_get_contents($target));
            $this->_cachebuster[$package]['debug'] = "{$package}.css?version={$md5}";

            // minified
            $target = "{$pathPublic}/{$package}.min.css";
            $minifier = new CssMinifier($content, $this->cssFilters, $this->cssPlugins);
            file_put_contents($target, $minifier->getMinified());
            $this->log('- written ' . $target);

            // cachebuster files production min
            $md5 = md5(file_get_contents($target));
            $this->_cachebuster[$package]['min'] = "{$package}.min.css?version={$md5}";
        }

        // write cachebuster file
        $cachebuster = dirname($this->file) . '/css.php';
        @unlink($cachebuster);
        file_put_contents($cachebuster, '<?php return ' . var_export($this->_cachebuster, true) . ';');
        $this->log('- written ' . $cachebuster);

        // change back to baseDir
        chdir($cwd);
    }
}