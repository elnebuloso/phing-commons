<?php
namespace elnebuloso\PhingCommons\Phing\Task\Composer;

use BuildException;
use stdClass;
use Task;

/**
 * Class FormatTask
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class FormatTask extends Task
{
    /**
     * @var string
     */
    private $composerFile;

    /**
     * @var array
     */
    private $composerStructure;

    /**
     * @param string $composerFile
     */
    public function setComposerFile($composerFile)
    {
        $this->composerFile = $composerFile;
    }

    /**
     * @throws BuildException
     * @return void
     */
    public function main()
    {
        $this->composerStructure = [
            'name' => '',
            'description' => '',
            'license' => '',
            'type' => '',
            'keywords' => [],
            'authors' => [],
            'require' => new stdClass(),
            'require-dev' => new stdClass(),
            'autoload' => new stdClass(),
            'autoload-dev' => new stdClass(),
            'suggest' => new stdClass(),
            'conflict' => new stdClass(),
            'extra' => new stdClass(),
        ];

        $content = file_get_contents($this->composerFile);

        if ($content === false) {
            throw new BuildException('unable to receive content from composer file: ' . $this->composerFile);
        }

        $content = json_decode($content, true);

        if ($content === null) {
            throw new BuildException('unable to decode content from composer file: ' . $this->composerFile);
        }

        $content = $this->updateStructure($content);
        $content = $this->updateComposerProperty($content, 'name', 'composer.name');
        $content = $this->updateComposerProperty($content, 'description', 'composer.description');
        $content = $this->updateComposerProperty($content, 'type', 'composer.type');
        $content = $this->updateComposerProperty($content, 'license', 'composer.license');
        $content = $this->updateComposerKeywords($content);
        $content = $this->updateRequirePhp($content);

        if (file_put_contents($this->composerFile, json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) === false) {
            throw new BuildException('unable to write formatted composer file: ' . $this->composerFile);
        }
    }

    /**
     * @param array $composer
     * @return array
     */
    private function updateStructure(array $composer)
    {
        $composer = array_replace($this->composerStructure, $composer);

        foreach ($this->composerStructure as $name => $item) {
            if ($item instanceof stdClass) {
                if (!isset($composer[$name]) || (is_array($composer[$name]) && empty($composer[$name]))) {
                    $composer[$name] = $item;
                }
            }
        }

        return $composer;
    }

    /**
     * @param array $composer
     * @param string $property
     * @param string $buildProperty
     * @return array
     */
    private function updateComposerProperty(array $composer, $property, $buildProperty)
    {
        if (!empty($this->getComposerProperty($buildProperty))) {
            $composer[$property] = $this->getComposerProperty($buildProperty);
        }

        return $composer;
    }

    /**
     * @param array $composer
     * @return array
     */
    private function updateComposerKeywords(array $composer)
    {
        if (empty($this->getComposerProperty('composer.keywords'))) {
            return $composer;
        }

        $keywords = $this->getComposerProperty('composer.keywords');
        $keywords = explode(',', $keywords);
        $keywords = array_filter(array_map('trim', $keywords));

        $composer['keywords'] = $keywords;

        return $composer;
    }

    /**
     * @param array $composer
     * @return array
     */
    private function updateRequirePhp(array $composer)
    {
        if (!empty($this->getComposerProperty('composer.require.php'))) {
            $composer['require']['php'] = $this->getComposerProperty('composer.require.php');
        }

        return $composer;
    }

    /**
     * @param string $name
     * @return null|string
     */
    private function getComposerProperty($name)
    {
        $value = trim($this->getProject()->getProperty($name));

        if (!empty($value)) {
            return $value;
        }

        return null;
    }
}
