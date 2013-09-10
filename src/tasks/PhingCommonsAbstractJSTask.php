<?php
/**
 * Class PhingCommonsAbstractJSTask
 */
abstract class PhingCommonsAbstractJSTask extends Task {

    /**
     * @var
     */
    protected $targetDir;

    /**
     * @var string
     */
    protected $java = 'java';

    /**
     * @var string
     */
    protected $compileLevel = 'SIMPLE_OPTIMIZATIONS';

    /**
     * @var string
     */
    protected $compileWarningLevel = 'DEFAULT';

    /**
     * @var
     */
    protected $compiler;

    /**
     * @param $targetDir
     */
    public function setTargetDir($targetDir) {
        $this->targetDir = $targetDir;
    }

    /**
     * @param $java
     */
    public function setJava($java) {
        $this->java = $java;
    }

    /**
     * @param $compileLevel
     */
    public function setCompileLevel($compileLevel) {
        $this->compileLevel = $compileLevel;
    }

    /**
     * @param $compileWarningLevel
     */
    public function setCompileWarningLevel($compileWarningLevel) {
        $this->compileWarningLevel = $compileWarningLevel;
    }

    /**
     * main
     */
    public function main() {
        $this->compiler = dirname(__FILE__) . '/vendor/google/closure-compiler/compiler.jar';
        $this->compiler = realpath($this->compiler);
    }

    /**
     * @param $content
     * @return string
     * @throws BuildException
     */
    protected function compile($content) {
        $size = strlen($content);
        $this->log("- Minifying $size bytes to single file.");

        $descriptorspec = array(
            array(
                'pipe',
                'r'
            ),
            array(
                'pipe',
                'w'
            )
        );

        $command = "{$this->java} -jar {$this->compiler} --compilation_level={$this->compileLevel} --warning_level={$this->compileWarningLevel}";

        $process = proc_open($command, $descriptorspec, $pipes);

        if(is_resource($process)) {
            fwrite($pipes[0], $content);
            fclose($pipes[0]);

            $content = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $return = proc_close($process);

            if($return) {
                throw new BuildException('- Compiler exited with: ' . $return);
            }

            $ratio = !empty($size) ? strlen($content) / $size : 0;
            $this->log("- Compression ratio: $ratio (" . strlen($content) . "/$size)");
        }
        else {
            throw new BuildException('- Wrong Ressource for compiling');
        }

        return $content;
    }
}