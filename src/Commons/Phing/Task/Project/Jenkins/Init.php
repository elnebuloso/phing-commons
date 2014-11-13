<?php
/**
 * Class Update
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Commons_Phing_Task_Project_Jenkins_Init extends Task {

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $propertiesFile;

    /**
     * @var array
     */
    private $properties;

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
        $this->properties = parse_ini_file($this->propertiesFile);

        if($this->properties === false) {
            throw new \BuildException('unable to parse properties file');
        }

        $fp = fopen(dirname($this->propertiesFile) . '/build.properties.jenkins', "w+");

        if(flock($fp, LOCK_EX)) {
            ftruncate($fp, 0); // write new file content

            $this->writeIniSetting($fp, 'PBC_PROJECT_VERSION_JENKINS', $this->version);
            $this->writeIniSettingFromBuildProperty($fp, 'project.vendor');
            $this->writeIniSettingFromBuildProperty($fp, 'project.name');

            flock($fp, LOCK_UN); // release lock
        }
        else {
            throw new \BuildException('unable to lock properties file for update');
        }

        fclose($fp);
    }

    /**
     * @param resource $fp
     * @param string $key
     * @param string $value
     * @return string
     */
    private function writeIniSetting($fp, $key, $value) {
        fwrite($fp, "$key = $value" . PHP_EOL);
    }

    /**
     * @param resource $fp
     * @param string $key
     */
    private function writeIniSettingFromBuildProperty($fp, $key) {
        if(array_key_exists($key, $this->properties)) {
            $this->writeIniSetting($fp, 'PBC_' . strtoupper(str_replace('.', '_', $key)), $this->properties[$key]);
        }
    }
}