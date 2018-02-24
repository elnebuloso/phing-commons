<?php
namespace elnebuloso\PhingCommons\Phing\Task\Bundle;

use Bundler\StylesheetBundler;
use Task;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;

/**
 * Class StylesheetBundlerTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class StylesheetBundlerTask extends Task
{
    /**
     * @var string
     */
    private $file;

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @throws \BuildException
     * @return void
     */
    public function main()
    {
        $writer = new StreamWriter('php://output');
        $logger = new Logger();
        $logger->addWriter($writer);

        $bundler = new StylesheetBundler($this->file);
        $bundler->getBundlerLogger()->setLogger($logger);
        $bundler->bundle();
    }
}
