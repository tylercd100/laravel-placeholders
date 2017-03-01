<?php

namespace Tylercd100\Placeholders\Tests;

use Exception;
use Tylercd100\Placeholders\Placeholders as PlaceholdersClass;
use Tylercd100\Placeholders\Facades\Placeholders;

class PlaceholdersTest extends TestCase
{
    public function testItCreatesAnInstanceOfPlaceholders()
    {
        $obj = new PlaceholdersClass();
        $this->assertInstanceOf(PlaceholdersClass::class, $obj);
    }

    public function testSimpleReplacement()
    {
        $x = Placeholders::parse("I like [fruit]s and [veg]s", [
            'fruit' => 'orange',
            'veg' => 'cucumber'
        ]);
        $this->assertEquals("I like oranges and cucumbers", $x);
    }

    public function testGlobalReplacement()
    {
        Placeholders::set("fruit", "apple");
        Placeholders::set("veg", "carrot");
        $x = Placeholders::parse("I like [fruit]s and [veg]s");
        $this->assertEquals("I like apples and carrots", $x);
    }

    public function testGlobalReplacementWithOverwrite()
    {
        Placeholders::set("fruit", "apple");
        Placeholders::set("veg", "carrot");
        $x = Placeholders::parse("I like [fruit]s and [veg]s", ["fruit" => "watermelon"]);
        $this->assertEquals("I like watermelons and carrots", $x);
    }

    public function testThrowsErrorWhenAPlaceholderIsSkipped()
    {
        $this->setExpectedException(Exception::class);
        Placeholders::parse("I like [fruit]s and [veg]s");
    }

    public function testItDoesntThrowAnErrorWhenChangingSetting()
    {
        Placeholders::setThorough(false);
        $x = Placeholders::parse("I like [fruit]s and [veg]s");
        $this->assertEquals("I like [fruit]s and [veg]s", $x);
    }

    public function setDifferentPlaceholderStyle()
    {
        $r = ['fruit' => 'orange', 'veg' => 'cucumber'];

        // One and then the other
        Placeholders::setStart("{{");
        Placeholders::setEnd("}}");
        $x = Placeholders::parse("I like {{fruit}}s and {{veg}}s", $r);
        $this->assertEquals("I like oranges and cucumbers", $x);

        // Same time
        Placeholders::setStyle("^", "$");
        $x = Placeholders::parse("I like ^fruit$s and ^veg$s", $r);
        $this->assertEquals("I like oranges and cucumbers", $x);
    }
}
