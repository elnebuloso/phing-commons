<?php
/**
 * Class Update
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Commons_Phing_Task_Version_Update extends Task {

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $propertiesFile;

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
     * @param string $propertiesFile
     */
    public function setPropertiesFile($propertiesFile) {
        $this->propertiesFile = trim($propertiesFile);

        if(realpath($this->propertiesFile) === false) {
            throw new \BuildException('missing properties file');
        }
    }

    /**
     * @return void
     */
    public function main() {
        $properties = parse_ini_file($this->propertiesFile);

        if($properties === false) {
            throw new \BuildException('unable to parse properties file');
        }

        // remove properties that were updated
        $this->unsetProperty($properties, 'project.version');
        $this->unsetProperty($properties, 'PBC_PROJECT_VERSION');

        $fp = fopen($this->propertiesFile, "r+");

        if(flock($fp, LOCK_EX)) {
            ftruncate($fp, 0); // write new file content

            foreach($properties as $key => $value) {
                fwrite($fp, $this->getIniSetting($key, $value));
            }

            fwrite($fp, PHP_EOL);
            fwrite($fp, ';JENKINS ENVIRONMENT VARIABLES' . PHP_EOL);
            fwrite($fp, $this->getIniSetting('PBC_PROJECT_VERSION', $this->version));

            fwrite($fp, PHP_EOL);
            fwrite($fp, '[JENKINS]' . PHP_EOL);
            fwrite($fp, $this->getIniSetting('PBC_PROJECT_VERSION_JENKINS', $this->version));

            flock($fp, LOCK_UN); // release lock
        }
        else {
            throw new \BuildException('unable to lock properties file for update');
        }

        fclose($fp);
    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     */
    private function getIniSetting($key, $value) {
        return "$key = $value" . PHP_EOL;
    }

    /**
     * @param array $properties
     * @param string $key
     */
    private function unsetProperty(array &$properties, $key) {
        unset($properties[$key]);
    }
}