<?php

namespace MauticPlugin\Idea2TrelloBundle\Openapi\Service;

use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\XmlDeserializationVisitor;

class JmsSerializer implements SerializerInterface
{
    protected $serializer;

    public function __construct()
    {
        $naming_strategy = new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy());
        $this->serializer = SerializerBuilder::create()
            ->setDeserializationVisitor('json', new StrictJsonDeserializationVisitor($naming_strategy))
            ->setDeserializationVisitor('xml', new XmlDeserializationVisitor($naming_strategy))
            ->build()
        ;
    }

    public function serialize($data, $format)
    {
        return SerializerBuilder::create()->build()->serialize($data, $this->convertFormat($format));
    }

    public function deserialize($data, $type, $format)
    {
        if ('string' == $format) {
            return $this->deserializeString($data, $type);
        }

        // If we end up here, let JMS serializer handle the deserialization
        return $this->serializer->deserialize($data, $type, $this->convertFormat($format));
    }

    private function convertFormat($format)
    {
        switch ($format) {
            case 'application/json':
                return 'json';
            case 'application/xml':
                return 'xml';
        }

        return null;
    }

    private function deserializeString($data, $type)
    {
        // Figure out if we have an array format
        if (1 === preg_match('/array<(csv|ssv|tsv|pipes),(int|string)>/i', $type, $matches)) {
            return $this->deserializeArrayString($matches[1], $matches[2], $data);
        }

        switch ($type) {
            case 'int':
            case 'integer':
                if (is_int($data)) {
                    return $data;
                }

                if (is_numeric($data)) {
                    return $data + 0;
                }

                break;
            case 'string':
                break;
            case 'boolean':
            case 'bool':
                if ('true' === strtolower($data)) {
                    return true;
                }

                if ('false' === strtolower($data)) {
                    return false;
                }

                break;
        }

        // If we end up here, just return data
        return $data;
    }

    private function deserializeArrayString($format, $type, $data)
    {
        // Parse the string using the correct separator
        switch ($format) {
            case 'csv':
                $data = explode(',', $data);

                break;
            case 'ssv':
                $data = explode(' ', $data);

                break;
            case 'tsv':
                $data = explode("\t", $data);

                break;
            case 'pipes':
                $data = explode('|', $data);

                break;
            default:
                $data = [];
        }

        // Deserialize each of the array elements
        foreach ($data as $key => $item) {
            $data[$key] = $this->deserializeString($item, $type);
        }

        return $data;
    }
}
