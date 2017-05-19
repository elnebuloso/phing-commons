<?php
namespace elnebuloso\PhingCommons\Phing\Task\System;

use BuildException;
use PhingFile;
use ProjectConfigurator;
use Task;

/**
 * Class ImportChainsTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class ImportChainsTask extends Task
{
    /**
     * @var string
     */
    private $pathToChainFolder;

    /**
     * @var array
     */
    private $chains = [];

    /**
     * @param string $pathToChainFolder
     */
    public function setPathToChainFolder($pathToChainFolder)
    {
        $this->pathToChainFolder = $pathToChainFolder;
    }

    /**
     * @param string $chains
     */
    public function setChains($chains)
    {
        $this->chains = trim(strtolower($chains));
        $this->chains = explode(',', $chains);
        $this->chains = array_map('trim', $this->chains);
        $this->chains = array_filter($this->chains);

        if (!is_array($this->chains)) {
            $this->chains = [];
        }
    }

    /**
     * @return void
     * @throws BuildException
     */
    public function main()
    {
        if (realpath($this->pathToChainFolder) === false) {
            throw new BuildException('invalid path to chain folder');
        }

        foreach ($this->chains as $chain) {
            $file = new PhingFile($this->pathToChainFolder . '/' . $chain . '.xml');
            ProjectConfigurator::configureProject($this->project, $file);
        }
    }
}
