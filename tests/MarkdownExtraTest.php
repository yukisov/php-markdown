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
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDivUsingJapanese()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributesUsingJapanese());

        $this->assertContains('<div class="myClassName">例</div><pre><code id="baz" class="bar" lang="en" title="例">', $html);
        $this->assertContains('</code></pre>', $html);
    }


    /**
     * @test
     */
    public function headerLinkIconEnabled()
    {
        $this->MarkdownExtra->hli_enable = true;
        $this->MarkdownExtra->hli_icon_html = '<i class="fa fa-link"></i>';
        $this->MarkdownExtra->hli_anchor_class = 'header-link-anchor';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithHeaderLinkIcon());

        $this->assertContains('<h3><span id="3-3" class="header-link-anchor"></span>', $html);
        $this->assertContains('<a href="#4-2">', $html);
        $this->assertContains('<i class="fa fa-link"></i>', $html);
        $this->assertContains('<span>H4-2</span>', $html);
    }

    /**
     * @test
     */
    public function headerLinkIconDisabled()
    {
        $this->MarkdownExtra->hli_enable = false;
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithHeaderLinkIcon());

        $this->assertContains('<h2>H2-1</h2>', $html);
        $this->assertContains('<h3>H3-3</h3>', $html);
        $this->assertContains('<h4>H4-2</h4>', $html);
    }

    /**
     * @test
     */
    public function seTextHeading()
    {
        $html1 = $this->MarkdownExtra->transform($this->getSampleMarkdownSetextHeading());
        $html2 = $this->MarkdownExtra->transform($this->getSampleMarkdownAtxHeading());

        $this->assertContains('<h1>bbbbbb</h1>', $html1);
        $this->assertContains('<h1>bbbbbb</h1>', $html2);
    }

    /**
     * @test
     */
    public function headerUnderBlockquote_should_be_NG()
    {
        $this->MarkdownExtra->hli_enable = true;
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownHeaderUnderBlockquote());

        $this->assertContains('<h1>TitleB</h1>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDivUsingParenthesis()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributesUsingParenthesis());

        $this->assertContains('<div class="myClassName">日本語(括弧)</div><pre><code id="baz" class="bar" lang="en" title="日本語(括弧)">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    /**
     * @test
     */
    public function doFencedCodeBlocksWithTitleAttributeAndItsDivUsingParenthesis2()
    {
        $this->MarkdownExtra->fcb_output_title = true;
        $this->MarkdownExtra->fcb_title_div_class = 'myClassName';
        $html = $this->MarkdownExtra->transform($this->getSampleMarkdownTextWithExtraAttributesUsingParenthesis2());

        $this->assertContains('<div class="myClassName">日本語（括弧）</div><pre><code id="baz" class="bar" lang="en" title="日本語（括弧）">', $html);
        $this->assertContains('</code></pre>', $html);
    }

    //----------------
    // Html Sample
    //----------------

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

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithExtraAttributesUsingJapanese()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=例}
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
    private function getSampleMarkdownTextWithHeaderLinkIcon()
    {
        $markdownText = <<<EOD
aaa

# H1-1

bbb

## H2-1

ccc

## H2-2

ddd

### H3-1

eee

### H3-2

fff

# H1-2

ggg

## H2-3

hhh

### H3-3

iii

#### H4-1

jjj

#### H4-2

kkk

EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownSetextHeading()
    {
        $markdownText = <<<EOD
aaa

bbbbbb
======

cccc

EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownAtxHeading()
    {
        $markdownText = <<<EOD
aaa

# bbbbbb

cccc

EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownHeaderUnderBlockquote()
    {
        $markdownText = <<<EOD

# TitleA

> # TitleB
>
> cccc

ddd

EOD;
        return $markdownText;
    }

    /**
     * @return string
     */
    private function getSampleMarkdownTextWithExtraAttributesUsingParenthesis()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=日本語(括弧)}
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
    private function getSampleMarkdownTextWithExtraAttributesUsingParenthesis2()
    {
        $markdownText = <<<EOD
aaa

~~~ {.bar #baz lang=en title=日本語（括弧）}
function foo() {
    echo 'hello';
}
~~~

bbb
EOD;
        return $markdownText;
    }

}
