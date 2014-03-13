<?php
namespace PhingCommonsTest;

use PhingCommons\Version;

/**
 * Class VersionTest
 *
 * @package PhingCommonsTest
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class VersionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return void
     */
    public function test_getVersion() {
        $this->assertNotEmpty(Version::getVersion());
    }
}