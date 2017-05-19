<?php
namespace elnebuloso\PhingCommonsTest;

use elnebuloso\PhingCommons\PHPUnitClass;
use PHPUnit\Framework\TestCase;

/**
 * This Class is only for testing latest PHPUnit and PHPUnit Coverage from Phing
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class PHPUnitClassTest extends TestCase
{
    /**
     * @test
     */
    public function testFoo()
    {
        $class = new PHPUnitClass();
        $class->setFoo('foo');

        $this->assertEquals('foo', $class->getFoo());
    }
}
