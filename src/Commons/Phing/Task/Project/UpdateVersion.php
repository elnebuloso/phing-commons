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
    private $version;

    /**
     * @var string
     */
    private $composerJson;

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

    /**
     * @param string $composerJson
     */
    public function setComposerJson($composerJson) {
        $this->composerJson = trim($composerJson);
    }

    /**
     * @return string
     */
    public function getComposerJson() {
        return $this->composerJson;
    }

    public function main() {
        if(realpath($this->composerJson) !== false) {
            $this->updateComposerJson();
        }
    }

    private function updateComposerJson() {
        $data = json_decode(file_get_contents($this->composerJson), true);
        $edit = array(
            'version' => $this->version
        );

        if(!array_key_exists('version', $data)) {
            $data = array_merge($edit, $data);
        }
        else {
            $data = array_merge($data, $edit);
        }

        file_put_contents($this->composerJson, json_encode($data, JSON_PRETTY_PRINT));

        $this->log("updated {$this->composerJson}");
    }
}