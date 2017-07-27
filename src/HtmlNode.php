<?php

namespace Spatie\Crawler;

use DOMElement;

class HtmlNode
{
    /** @var \DOMElement */
    protected $node;

    protected $nodeType;

    /**
     * @param \DOMElement $node
     *
     * @return static
     */
    public static function create(DOMElement $node)
    {
        return new static($node);
    }

    public function __construct(DOMElement $node)
    {
        $this->node = $node;
        $this->nodeType = $node->nodeName;
    }

    /**
     * @param void
     *
     * @return \DOMElement
     */
    public function getNode(): DOMElement
    {
        return $this->node;
    }

    /**
     * @param void
     *
     * @return string
     */
    public function getNodeType(): string
    {
        return $this->nodeType;
    }

    /**
     * @param void
     *
     * @return string
     */
    public function getHtml(): string
    {
        return $this->node->ownerDocument->saveHTML($this->node);
    }

    /**
     * @param void
     *
     * @return string
     */
    public function getHtmlAndUpdateHref(string $href): string
    {
      if ($this->nodeType == "a") {
        return $this->node->setAttribute('href', $href)->ownerDocument->saveHTML($this->node);
      } elseif ($this->nodeType == "img") {
        return $this->node->setAttribute('src', $href)->ownerDocument->saveHTML($this->node);
      }
    }
}
