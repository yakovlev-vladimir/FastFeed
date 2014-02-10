<?php
/**
 * This file is part of the FastFeed package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastFeed\Tests\Parser;

use FastFeed\Item;
use FastFeed\Parser\AtomParser;

/**
 * AtomFirstElementParserTest
 */
class AtomFirstElementParserTest extends AbstractAtomParserTest
{
    public function dataProvider()
    {
        $this->parser = new AtomParser();
        $data = array();

        foreach ($this->xmls as $xml) {
            $content = file_get_contents(__DIR__ . $this->path . $xml);
            $nodes = $this->parser->getNodes($content);
            $data[] = array(
                array_shift($nodes),
                $content,
                $xml
            );
        }

        return $data;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testId(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/ns:id[1]");

        $this->assertEquals(
            $expected,
            $item->getId(),
            'Fail asserting that first element of ' . $fileName . ' has id "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testName(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/ns:title[1]");

        $this->assertEquals(
            $expected,
            $item->getName(),
            'Fail asserting that first element of ' . $fileName . ' has name "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIntro(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/ns:content[1]");

        $this->assertEquals(
            $expected,
            $item->getIntro(),
            'Fail asserting that first element of ' . $fileName . ' has intro "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testContent(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/ns:content[1]");

        $this->assertEquals(
            $expected,
            $item->getContent(),
            'Fail asserting that first element of ' . $fileName . ' has content "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSource(Item $item, $content, $fileName)
    {
        $expected = $this->getFistAttributeFromXpath($content, "*/ns:link[@type='text/html']", 'href');

        $this->assertEquals(
            $expected,
            $item->getSource(),
            'Fail asserting that first element of ' . $fileName . ' has source "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAuthor(Item $item, $content, $fileName)
    {
        $expected = $this->getFirstValueFromXpath($content, "*/ns:email");

        $this->assertEquals(
            $expected,
            $item->getAuthor(),
            'Fail asserting that first element of ' . $fileName . ' has author "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testImage(Item $item, $content, $fileName)
    {
        $expected = null;

        $this->assertEquals(
            $expected,
            $item->getImage(),
            'Fail asserting that first element of ' . $fileName . ' has image "' . $expected . '"'
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDate(Item $item, $content, $fileName)
    {
        $expected = strtotime($this->getFirstValueFromXpath($content, "*/ns:published"));

        $this->assertEquals(
            $expected,
            $item->getDate()->getTimestamp(),
            'Fail in assert of first element date of ' . $fileName . '  '
        );
    }
} 