<?php

namespace Sucre;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @backupStaticAttributes enabled
 */
class SucreSessionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SESSION = [];
        parent::setUp();
    }

    public function tearDown()
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testInit()
    {
        self::assertEquals(PHP_SESSION_NONE, session_status());
        @Session::init();
        self::assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    public function testInitWithRegenerated()
    {
        self::assertFalse(Session::regenerated());
        @Session::init(true);
        self::assertTrue(Session::regenerated());
    }

    public function testGetNullIfEmpty()
    {
        self::assertNull(Session::get('not_exists'));
    }

    public function testSet()
    {
        Session::set('example_key', 'example_value');
        self::assertEquals('example_value', $_SESSION['example_key']);
    }

    public function testSetAndGet()
    {
        self::assertNull(Session::get('example_key'));
        Session::set('example_key', 'example_value');
        self::assertEquals('example_value', Session::get('example_key'));
    }
}
