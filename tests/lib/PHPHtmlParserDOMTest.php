<?php

use PHPHtmlParser\Dom;

class PHPHtmlParserDOMTest extends TestCase
{
    private $dom;

    public function setUp()
    {
        parent::setUp();

        $this->dom = new Dom;
    }

    public function tesarDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function divElementWithAttributes_OK()
    {
        $payloads = [
            "foo bar",
        ];
        foreach ($payloads as $payload) {
            $html = sprintf('<div title="%s"></div>', $payload);
            $this->dom->load($html);
            $a = $this->dom->find('div')[0];
            $this->assertContains($payload, $a->getAttribute('title'));
        }
    }

    /**
     * @test
     */
    public function divElementWithAttributes_OK2()
    {
        $payloads = [
            "foo bar",
        ];
        foreach ($payloads as $payload) {
            $html = sprintf("<div title='%s'></div>", $payload);
            $this->dom->load($html);
            $a = $this->dom->find('div')[0];
            $this->assertContains($payload, $a->getAttribute('title'));
        }
    }

    /**
     * @test
     */
    public function divElementWithAttributes_OK3()
    {
        $payloads = [
            "foo",
        ];
        foreach ($payloads as $payload) {
            $html = sprintf("<div title=%s></div>", $payload);
            $this->dom->load($html);
            $a = $this->dom->find('div')[0];
            $this->assertContains($payload, $a->getAttribute('title'));
        }
    }

    /**
     * @test
     *
     * memo:
     *   - 属性値はクォートで囲まなくてもよいが、その場合、属性値としてスペースは使えない。（当たり前ではある）
     *
     */
    public function divElementWithAttributes_NG()
    {
        $payloads = [
            "foo bar",
        ];
        foreach ($payloads as $payload) {
            $html = sprintf("<div title=%s></div>", $payload);
            $this->dom->load($html);
            $a = $this->dom->find('div')[0];
            $this->assertNotContains($payload, $a->getAttribute('title'));
        }
    }

}
