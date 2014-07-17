<?php
/**
 * Class UpdateVersion
 *
 * @package Commons\Phing\Task\Project
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Commons_Phing_Task_Project_UpdateVersion extends Task {

    /**
     * @var string
     */
    private $composerJson;

    /**
     * @var string
     */
    private $version;

    /**
     * @param string $composerJson
     * @throws \BuildException
     */
    public function setComposerJson($composerJson) {
        $this->composerJson = trim($composerJson);

        if(empty($this->composerJson)) {
            throw new \BuildException('missing path to composer.json');
        }

        if(realpath($this->composerJson) === false) {
            throw new \BuildException('missing composer.json');
        }
    }

    /**
     * @return string
     */
    public function getComposerJson() {
        return $this->composerJson;
    }

    /**
     * @param string $version
     * @throws \BuildException
     */
    public function setVersion($version) {
        $this->version = trim($version);

        if(empty($this->version)) {
            throw new \BuildException('missing version');
        }
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    public function main() {
    }
}