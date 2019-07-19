<?php

namespace Aplr\Toolbox\Xml;

use SimpleXMLElement;

class XPathMapping
{

    private $path;
    private $mapping;
    private $collection;
    private $namespaces;

    public function __construct(string $path, array $mapping = [], bool $collection = true)
    {
        $this->path = $path;
        $this->mapping = collect($mapping);
        $this->collection = $collection;
        $this->namespaces = collect();
    }

    public static function map(string $path, array $mapping = [], bool $collection = true): XPathMapping
    {
        return new self($path, $mapping, $collection);
    }

    public static function collection(string $path): XPathMapping
    {
        return new self($path, [], true);
    }

    public function namespace(array $mapping): XPathMapping
    {
        collect($mapping)->each(function ($ns, $prefix) {
            $this->namespaces->put($prefix, $ns);
        });
        
        return $this;
    }

    public function getPath(): String
    {
        return $this->path;
    }

    public function getMapping(): String
    {
        return $this->mapping;
    }

    public function parse(SimpleXMLElement $xml)
    {
        $this->namespaces->each(function ($ns, $prefix) use ($xml) {
            $xml->registerXPathNamespace($prefix, $ns);
        });

        $mapping = $this->mapping;
        $elements = collect($xml->xpath($this->path));
        
        $elements->each(function ($element) {
            $this->namespaces->each(function ($ns, $prefix) use ($element) {
                $element->registerXPathNamespace($prefix, $ns);
            });
        });

        if ($this->collection && $this->mapping->count() == 0) {
            return $elements->map(function ($element) {
                return $element->__toString();
            });
        }

        $mapped = $elements->map(function ($xml) {
            return $this->mapValues($xml);
        });

        if (!$this->collection && $mapped->count() > 0) {
            return $mapped[0];
        }

        return $mapped;
    }

    private function mapValues(SimpleXMLElement $element)
    {
        return $this->mapping->map(function ($xelement) use ($element) {
            return $this->mapValue($element, $xelement);
        });
    }

    private function mapValue(SimpleXMLElement $element, $path)
    {
        if ($path instanceof XPathMapping) {
            return $path->namespace($this->namespaces->toArray())->parse($element);
        } elseif ($path instanceof XPathValue) {
            return $path->namespace($this->namespaces->toArray())->parse($element);
        } elseif (is_string($path)) {
            $items = collect($element->xpath($path))->map(function ($node) {
                return $node->__toString();
            });

            if (count($items) > 0 && is_string($items[0])) {
                return $items[0];
            }

            return null;
        }

        return null;
    }
}
