<?php

namespace App\Services;

use DOMAttr;
use DOMText;
use DOMElement;
use DOMDocument;
use DOMCdataSection;
use DOMNamedNodeMap;

class XmlToArray
{
    /**
     * @var DOMDocument
     */
    protected $document;

    /**
     * XmlToArray constructor.
     * @param string $xml
     */
    public function __construct(string $xml)
    {
        $this->document = new DOMDocument();
        $this->document->loadXML($xml);
    }

    /**
     * @param string $xml
     * @return array
     */
    public static function convert(string $xml): array
    {
        $converter = new static($xml);
        return $converter->toArray();
    }

    /**
     * @param DOMNamedNodeMap $nodeMap
     * @return array|null
     */
    protected function convertAttributes(DOMNamedNodeMap $nodeMap): ?array
    {
        if ($nodeMap->length === 0) {
            return null;
        }
        $result = [];
        /** @var DOMAttr $item */
        foreach ($nodeMap as $item) {
            $result[$item->name] = $item->value;
        }
        return ['_attributes' => $result];
    }

    /**
     * @param DOMElement $element
     * @return array|null
     */
    protected function convertDomElement(DOMElement $element)
    {

        $result = $this->convertAttributes($element->attributes);
        if ($element->childNodes->length > 1) {
            $childNodeNames = [];
            foreach ($element->childNodes as $key => $node) {
                $childNodeNames[] = $node->nodeName;
            }
        }
        foreach ($element->childNodes as $key => $node) {
            if ($node instanceof DOMCdataSection) {
                $result['_cdata'] = $node->data;
                continue;
            }
            if ($node instanceof DOMText) {
                if(!empty(trim($node->textContent))) $result['text'] = $node->textContent;
                continue;
            }
            if ($node instanceof DOMElement) {
                $result[$node->nodeName][] = $this->convertDomElement($node);
                continue;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        if ($this->document->hasChildNodes()) {
            $children = $this->document->childNodes;
            foreach ($children as $child) {
                $result[$child->nodeName] = $this->convertDomElement($child);
            }
        }
        return $result;
    }
}