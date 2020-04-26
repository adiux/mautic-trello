<?php

namespace MauticPlugin\Idea2TrelloBundle\Openapi\Service;

interface SerializerInterface
{
    /**
     * Serializes the given data to the specified output format.
     *
     * @param array|object|scalar $data
     * @param string              $format
     *
     * @return string
     */
    public function serialize($data, $format);

    /**
     * Deserializes the given data to the specified type.
     *
     * @param string $data
     * @param string $type
     * @param string $format
     *
     * @return array|object|scalar
     */
    public function deserialize($data, $type, $format);
}
