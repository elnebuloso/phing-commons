<?php
require_once 'AbstractBundlePublicTask.php';

/**
 * Class PhingCommonsBundleJSTask
 */
class PhingCommonsBundleJSTask extends AbstractBundlePublicTask {

    /**
     * @throws BuildException
     */
    public function main() {
        parent::main();

        foreach($this->_filesSelected as $package => $data) {
            if($this->_verbose) {
                $this->log("");
                $this->log("package: {$package}");

                $this->_content = array();
                $this->_destinationMax = "{$this->_folder}/{$package}.bundle.js";
                $this->_destinationMin = "{$this->_folder}/{$package}.bundle.min.js";

                foreach($data['files'] as $file) {
                    $this->_content[] = file_get_contents($file);
                }

                // create max file
                $this->_content = implode(PHP_EOL . PHP_EOL, $this->_content);
                file_put_contents($this->_destinationMax, $this->_content);

                // create min file
                if($this->_compiler == 'yuicompressor') {
                    $this->_compileWithYuiCompressor();
                }

                if($this->_compiler == 'google') {
                    $this->_compileWithGoogle();
                }

                $this->log("created: {$this->_destinationMax}");
                $this->log("created: {$this->_destinationMin}");

                $org = strlen(file_get_contents($this->_destinationMax));
                $new = strlen(file_get_contents($this->_destinationMin));
                $ratio = !empty($org) ? $new / $org : 0;

                $this->log("");
                $this->log("org: {$org} bytes");
                $this->log("new: {$new} bytes");
                $this->log("compression ratio: {$ratio}");
            }

            $this->log("");
            $this->log("package: {$package}");
            $this->log("include: " . count($data['includes']));
            $this->log("exclude: " . count($data['excludes']));
            $this->log("bundled: " . count($data['files']));
        }
    }

    /**
     * @return void
     */
    private function _compileWithYuiCompressor() {
        $compiler = dirname(__FILE__) . '/vendor/yuicompressor/2.4.8/yuicompressor.jar';
        $command = "{$this->_java} -jar {$compiler} --type js --line-break 5000 --nomunge --preserve-semi --disable-optimizations -o {$this->_destinationMin} {$this->_destinationMax}";
        exec($command);

        $this->log("compiled by yuicompressor");
    }

    /**
     * @link http://dl.google.com/closure-compiler/compiler-latest.zip
     * @return void
     */
    private function _compileWithGoogle() {
        $compiler = dirname(__FILE__) . '/vendor/google/compiler.jar';
        $command = "{$this->_java} -jar {$compiler} --compilation_level=SIMPLE_OPTIMIZATIONS --warning_level=QUIET --js={$this->_destinationMax} --js_output_file={$this->_destinationMin}";
        exec($command);

        $this->log("compiled by google");
    }
}