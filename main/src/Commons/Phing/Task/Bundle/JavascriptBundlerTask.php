<?php
namespace Commons\Phing\Task\Bundle;

use Bundler\JavascriptBundler;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;

/**
 * Class JavascriptBundlerTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class JavascriptBundlerTask extends \Task {

    /**
     * @var string
     */
    private $file;

    /**
     * @param string $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @throws \BuildException
     * @return void
     */
    public function main() {
        $writer = new StreamWriter('php://output');
        $logger = new Logger();
        $logger->addWriter($writer);

        $bundler = new JavascriptBundler($this->file);
        $bundler->getBundlerLogger()->setLogger($logger);
        $bundler->bundle();
    }
}