<?php
declare(strict_types=1);

namespace Behatch\Xml;

class Dom
{
    private \DomDocument $dom;

    /**
     * @throws \DomException
     */
    public function __construct($content)
    {
        $this->dom = new \DomDocument();
        $this->dom->strictErrorChecking = false;
        $this->dom->validateOnParse = false;
        $this->dom->preserveWhiteSpace = true;
        $this->dom->loadXML($content, LIBXML_PARSEHUGE);
        $this->throwError();
    }

    public function __toString()
    {
        $this->dom->formatOutput = true;

        return $this->dom->saveXML();
    }

    /**
     * @throws \DomException
     */
    public function validate(): void
    {
        $this->dom->validate();
        $this->throwError();
    }

    /**
     * @throws \DomException
     */
    public function validateXsd($xsd): void
    {
        $this->dom->schemaValidateSource($xsd);
        $this->throwError();
    }

    public function validateNg($ng): void
    {
        try {
            $this->dom->relaxNGValidateSource($ng);
            $this->throwError();
        } catch (\DOMException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function xpath($element): \DOMNodeList
    {
        $xpath = new \DOMXpath($this->dom);
        $this->registerNamespace($xpath);

        $element = $this->fixNamespace($element);
        $elements = $xpath->query($element);

        return $elements === false ? new \DOMNodeList() : $elements;
    }

    private function registerNamespace(\DOMXpath $xpath): void
    {
        $namespaces = $this->getNamespaces();

        foreach ($namespaces as $prefix => $namespace) {
            if (empty($prefix) && $this->hasDefaultNamespace()) {
                $prefix = 'rootns';
            }
            $xpath->registerNamespace($prefix, $namespace);
        }
    }

    /**
     * "fix" queries to the default namespace if any namespaces are defined
     */
    private function fixNamespace($element)
    {
        $namespaces = $this->getNamespaces();

        if (!empty($namespaces) && $this->hasDefaultNamespace()) {
            for ($i = 0; $i < 2; ++$i) {
                $element = preg_replace('/\/(\w+)(\[[^]]+\])?\//', '/rootns:$1$2/', $element);
            }
            $element = preg_replace('/\/(\w+)(\[[^]]+\])?$/', '/rootns:$1$2', $element);
        }

        return $element;
    }

    private function hasDefaultNamespace(): bool
    {
        $defaultNamespaceUri = $this->dom->lookupNamespaceURI(null);
        $defaultNamespacePrefix = $defaultNamespaceUri ? $this->dom->lookupPrefix($defaultNamespaceUri) : null;

        return empty($defaultNamespacePrefix) && !empty($defaultNamespaceUri);
    }

    public function getNamespaces(): array
    {
        $xml = \simplexml_import_dom($this->dom);

        return $xml->getNamespaces(true);
    }

    /**
     * @throws \DomException
     */
    private function throwError(): void
    {
        $error = \libxml_get_last_error();
        // https://bugs.php.net/bug.php?id=46465
        if (!empty($error) && $error->message !== 'Validation failed: no DTD found !') {
            throw new \DomException($error->message . ' at line ' . $error->line);
        }
    }
}
