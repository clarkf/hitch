<?php
namespace Hitch\Test;

use PHPUnit_Framework_TestCase;
use Mockery as m;

class TestCase extends PHPUnit_Framework_TestCase
{
    public function teardown()
    {
        m::close();
        parent::teardown();
    }
}
