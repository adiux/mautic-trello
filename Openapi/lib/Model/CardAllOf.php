<?php
/**
 * CardAllOf.
 *
 * PHP version 5
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://openapi-generator.tech
 */

/**
 * Mautic Trello API.
 *
 * Create or update a card via the Trello API
 *
 * The version of the OpenAPI document: 0.1.1
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.3.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MauticPlugin\MauticTrelloBundle\Openapi\lib\Model;

use ArrayAccess;
use MauticPlugin\MauticTrelloBundle\Openapi\lib\ObjectSerializer;

/**
 * CardAllOf Class Doc Comment.
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://openapi-generator.tech
 */
class CardAllOf implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $openAPIModelName = 'Card_allOf';

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $openAPITypes = [
        'id'               => 'string',
        'dateLastActivity' => '\DateTime',
        'labels'           => 'object[]',
        'due'              => '\DateTime',
        'url'              => 'string',
        'idMembers'        => 'string[]',
        'attachments'      => 'object[]',
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $openAPIFormats = [
        'id'               => null,
        'dateLastActivity' => 'date-time',
        'labels'           => null,
        'due'              => 'date-time',
        'url'              => 'uri',
        'idMembers'        => null,
        'attachments'      => null,
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id'               => 'id',
        'dateLastActivity' => 'dateLastActivity',
        'labels'           => 'labels',
        'due'              => 'due',
        'url'              => 'url',
        'idMembers'        => 'idMembers',
        'attachments'      => 'attachments',
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @var string[]
     */
    protected static $setters = [
        'id'               => 'setId',
        'dateLastActivity' => 'setDateLastActivity',
        'labels'           => 'setLabels',
        'due'              => 'setDue',
        'url'              => 'setUrl',
        'idMembers'        => 'setIdMembers',
        'attachments'      => 'setAttachments',
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @var string[]
     */
    protected static $getters = [
        'id'               => 'getId',
        'dateLastActivity' => 'getDateLastActivity',
        'labels'           => 'getLabels',
        'due'              => 'getDue',
        'url'              => 'getUrl',
        'idMembers'        => 'getIdMembers',
        'attachments'      => 'getAttachments',
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    /**
     * Associative array for storing property values.
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor.
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id']               = isset($data['id']) ? $data['id'] : null;
        $this->container['dateLastActivity'] = isset($data['dateLastActivity']) ? $data['dateLastActivity'] : null;
        $this->container['labels']           = isset($data['labels']) ? $data['labels'] : null;
        $this->container['due']              = isset($data['due']) ? $data['due'] : null;
        $this->container['url']              = isset($data['url']) ? $data['url'] : null;
        $this->container['idMembers']        = isset($data['idMembers']) ? $data['idMembers'] : null;
        $this->container['attachments']      = isset($data['attachments']) ? $data['attachments'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if (null === $this->container['id']) {
            $invalidProperties[] = "'id' can't be null";
        }
        if ((mb_strlen($this->container['id']) < 1)) {
            $invalidProperties[] = "invalid value for 'id', the character length must be bigger than or equal to 1.";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed.
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return 0 === count($this->listInvalidProperties());
    }

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id.
     *
     * @param string $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        if ((mb_strlen($id) < 1)) {
            throw new \InvalidArgumentException('invalid length for $id when calling CardAllOf., must be bigger than or equal to 1.');
        }

        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets dateLastActivity.
     *
     * @return \DateTime|null
     */
    public function getDateLastActivity()
    {
        return $this->container['dateLastActivity'];
    }

    /**
     * Sets dateLastActivity.
     *
     * @param \DateTime|null $dateLastActivity full-date notation as defined by RFC 3339, section 5.6. Default Timezone is UTC
     *
     * @return $this
     */
    public function setDateLastActivity($dateLastActivity)
    {
        $this->container['dateLastActivity'] = $dateLastActivity;

        return $this;
    }

    /**
     * Gets labels.
     *
     * @return object[]|null
     */
    public function getLabels()
    {
        return $this->container['labels'];
    }

    /**
     * Sets labels.
     *
     * @param object[]|null $labels labels
     *
     * @return $this
     */
    public function setLabels($labels)
    {
        $this->container['labels'] = $labels;

        return $this;
    }

    /**
     * Gets due.
     *
     * @return \DateTime|null
     */
    public function getDue()
    {
        return $this->container['due'];
    }

    /**
     * Sets due.
     *
     * @param \DateTime|null $due full-date notation as defined by RFC 3339, section 5.6. Default Timezone is UTC
     *
     * @return $this
     */
    public function setDue($due)
    {
        $this->container['due'] = $due;

        return $this;
    }

    /**
     * Gets url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->container['url'];
    }

    /**
     * Sets url.
     *
     * @param string|null $url url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->container['url'] = $url;

        return $this;
    }

    /**
     * Gets idMembers.
     *
     * @return string[]|null
     */
    public function getIdMembers()
    {
        return $this->container['idMembers'];
    }

    /**
     * Sets idMembers.
     *
     * @param string[]|null $idMembers Array of memebr ids as strings
     *
     * @return $this
     */
    public function setIdMembers($idMembers)
    {
        $this->container['idMembers'] = $idMembers;

        return $this;
    }

    /**
     * Gets attachments.
     *
     * @return object[]|null
     */
    public function getAttachments()
    {
        return $this->container['attachments'];
    }

    /**
     * Sets attachments.
     *
     * @param object[]|null $attachments attachments
     *
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->container['attachments'] = $attachments;

        return $this;
    }

    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param int $offset Offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param int $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int   $offset Offset
     * @param mixed $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param int $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object.
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
