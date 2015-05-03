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
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDiv()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithTitleAttribute());

        $this->assertContains('<div>abcdefg</div><pre><code id="baz" class="bar" title="abcdefg">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDiv2()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithTitleAttribute());

        $this->assertContains('<div class="myClassName">abcdefg</div><pre><code id="baz" class="bar" title="abcdefg">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDiv3()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributes3());

        // Output raw data because the parser could not understand this markdown text.
        $this->assertContains('~~~ {.bar #baz lang=en title=<script>alert(1)</script>}', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDivUsingSlash()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributesUsingSlash());

        $this->assertContains('<div class="myClassName">aaa/bbb/ccc.php</div><pre><code id="baz" class="bar" lang="en" title="aaa/bbb/ccc.php">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDivUsingSlash2()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributesUsingSlash2());

        $this->assertContains('<div class="myClassName">/aaa/bbb/ccc.php</div><pre><code id="baz" class="bar" lang="en" title="/aaa/bbb/ccc.php">', $html);
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

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithExtraAttributes3()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=<script>alert(1)</script>}
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
    private function getSampleMarkdownTextWithExtraAttributesUsingSlash()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=aaa/bbb/ccc.php}
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
    private function getSampleMarkdownTextWithExtraAttributesUsingSlash2()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=/aaa/bbb/ccc.php}
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }

}
