<?php
namespace Commons\Phing\Task\Composer;

/**
 * Class FormatTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class FormatTask extends \Task {

    /**
     * @var string
     */
    private $composerFile;

    /**
     * @param string $composerFile
     */
    public function setComposerFile($composerFile) {
        $this->composerFile = $composerFile;
    }

    /**
     * @throws \BuildException
     * @return void
     */
    public function main() {
        $content = file_get_contents($this->composerFile);

        if($content === false) {
            throw new \BuildException('unable to receive content from composer file: ' . $this->composerFile);
        }

        $content = json_decode($content, true);

        if($content === null) {
            throw new \BuildException('unable to decode content from composer file: ' . $this->composerFile);
        }

        if(file_put_contents($this->composerFile, json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) === false) {
            throw new \BuildException('unable to write formatted composer file: ' . $this->composerFile);
        }
    }
}