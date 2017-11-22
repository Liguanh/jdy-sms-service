<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/22/17
 * Time: 5:01 PM
 */

namespace Liguanh\JdySms\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

use Mockery;


class TestCase extends PHPUnitTestCase
{
    public function setUp()
    {
        Mockery::globalHelpers();
    }

    public function tearDown()
    {
        Mockery::close();
    }
}