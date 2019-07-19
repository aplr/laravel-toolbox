<?php

namespace Aplr\Toolbox\Xml;

use SimpleXMLElement;

class XPathValue
{

    private $path;
    private $type;
    private $namespaces;

    public function __construct(string $path, $type = null)
    {
        $this->path = $path;
        $this->type = $type;
        $this->namespaces = collect();
    }

    public function namespace(array $mapping): XPathValue
    {
        collect($mapping)->each(function ($ns, $prefix) {
            $this->namespaces->put($prefix, $ns);
        });
        
        return $this;
    }

    public static function cast(string $path, $type = null)
    {
        return new self($path, $type);
    }

    public function parse(SimpleXMLElement $xml)
    {
        $result = $xml->xpath($this->path);

        if (!(count($result) > 0)) {
            return null;
        }

        $value = $result[0]->__toString();

        return $this->castValue($value);
    }

    private function castValue($value)
    {
        if ($this->type) {
            settype($value, $this->type);
        }

        return $value;
    }
}
