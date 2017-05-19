<?php
namespace elnebuloso\PhingCommons;

/**
 * This Class is only for testing latest PHPUnit and PHPUnit Coverage from Phing
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class PHPUnitClass
{
    /**
     * @var string
     */
    private $foo;

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
}
