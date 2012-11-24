<?php
/**
 * Lemmy_LemmyTest
 *
 * @package Lemmy
 * @author  Jan Thoennessen <jan.thoennessen@googlemail.com>
 */
class Lemmy_LemmyTest extends PHPUnit_Framework_TestCase {

    /**
     * setup
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
    }

    /**
     * teardown
     *
     * @return void
     */
    public function tearDown() {
        parent::tearDown();
    }

    /**
     * test 1
     */
    public function testHelloWorldNotNull() {
        $this->assertNotNull(Lemmy_Lemmy::helloWorld(), 'output must not be null');
    }

    /**
     * test 2
     */
    public function testHelloWorldEquals() {
        $this->assertEquals('hello world', Lemmy_Lemmy::helloWorld(), 'output must be "hello world"');
    }
}