<?php
/**
 * Class UpdateVersion
 *
 * @package Commons\Phing\Task\Project
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Commons_Phing_Task_System_ImportChains extends Task {

    /**
     * @var string
     */
    private $pathToChainFolder;

    /**
     * @var array
     */
    private $chains = array();

    /**
     * @param string $pathToChainFolder
     */
    public function setPathToChainFolder($pathToChainFolder) {
        $this->pathToChainFolder = $pathToChainFolder;
    }

    /**
     * @param string $chains
     */
    public function setChains($chains) {
        $this->chains = trim(strtolower($chains));
        $this->chains = explode(',', $chains);
        $this->chains = array_map('trim', $this->chains);
        $this->chains = array_filter($this->chains);

        if(!is_array($this->chains)) {
            $this->chains = array();
        }
    }

    /**
     * @return void
     * @throws BuildException
     */
    public function main() {
        if(realpath($this->pathToChainFolder) === false) {
            throw new BuildException('invalid path to chain folder');
        }

        foreach($this->chains as $chain) {
            $import = new ImportTask();
            $import->setProject($this->project);
            $import->setFile($this->pathToChainFolder . '/' . $chain . '.xml');
            $import->init();
            $import->main();
        }
    }
}