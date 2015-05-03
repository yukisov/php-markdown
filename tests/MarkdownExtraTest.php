<?php

/*
 *  Memo:
 *  - ExtraAttributes seems unable to specify the string containing spaces as value.
 */

class MarkdownExtraTest extends TestCase
{
    private $MarkdownExtra;

    public function setUp()
    {
        parent::setUp();

        $this->MarkdownExtra = new \Michelf\MarkdownExtra();
    }

    public function tesarDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function doFencedCodeBlocks()
    {
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownText());

        $this->assertContains('<pre><code>', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithExtraAttributes()
    {
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributes());

        $this->assertContains('<pre><code id="baz" class="bar" lang="en">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttribute()
    {
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithTitleAttribute());

        $this->assertContains('<pre><code id="baz" class="bar" title="abcdefg">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithExtraAttributes2()
    {
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributes2());

        $this->assertContains('<pre><code id="baz" class="bar" lang="en" title="abcdefg">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @return string
     */
    private function getSampleMarkdownText()
    {
        $markdownText = <<<EOD
aaa

~~~
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithExtraAttributes()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en}
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithTitleAttribute()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz title=abcdefg}
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithExtraAttributes2()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=abcdefg}
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }
}
