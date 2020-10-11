<?php
/**
 * NewCard.
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

namespace MauticPlugin\Idea2TrelloBundle\Openapi\lib\Model;

use ArrayAccess;
use MauticPlugin\Idea2TrelloBundle\Openapi\lib\ObjectSerializer;

/**
 * NewCard Class Doc Comment.
 *
 * @category Class
 *
 * @author   OpenAPI Generator team
 *
 * @see     https://openapi-generator.tech
 */
class NewCard implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $openAPIModelName = 'NewCard';

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $openAPITypes = [
        'name'           => 'string',
        'idList'         => 'string',
        'desc'           => 'string',
        'pos'            => 'string',
        'due'            => '\DateTime',
        'urlSource'      => 'string',
        'contactId'      => 'int',
        'keepFromSource' => 'string',
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static $openAPIFormats = [
        'name'           => null,
        'idList'         => null,
        'desc'           => null,
        'pos'            => null,
        'due'            => 'date-time',
        'urlSource'      => 'uri',
        'contactId'      => null,
        'keepFromSource' => null,
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
        'name'           => 'name',
        'idList'         => 'idList',
        'desc'           => 'desc',
        'pos'            => 'pos',
        'due'            => 'due',
        'urlSource'      => 'urlSource',
        'contactId'      => 'contactId',
        'keepFromSource' => 'keepFromSource',
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @var string[]
     */
    protected static $setters = [
        'name'           => 'setName',
        'idList'         => 'setIdList',
        'desc'           => 'setDesc',
        'pos'            => 'setPos',
        'due'            => 'setDue',
        'urlSource'      => 'setUrlSource',
        'contactId'      => 'setContactId',
        'keepFromSource' => 'setKeepFromSource',
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @var string[]
     */
    protected static $getters = [
        'name'           => 'getName',
        'idList'         => 'getIdList',
        'desc'           => 'getDesc',
        'pos'            => 'getPos',
        'due'            => 'getDue',
        'urlSource'      => 'getUrlSource',
        'contactId'      => 'getContactId',
        'keepFromSource' => 'getKeepFromSource',
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
        $this->container['name']           = isset($data['name']) ? $data['name'] : null;
        $this->container['idList']         = isset($data['idList']) ? $data['idList'] : null;
        $this->container['desc']           = isset($data['desc']) ? $data['desc'] : null;
        $this->container['pos']            = isset($data['pos']) ? $data['pos'] : null;
        $this->container['due']            = isset($data['due']) ? $data['due'] : null;
        $this->container['urlSource']      = isset($data['urlSource']) ? $data['urlSource'] : null;
        $this->container['contactId']      = isset($data['contactId']) ? $data['contactId'] : null;
        $this->container['keepFromSource'] = isset($data['keepFromSource']) ? $data['keepFromSource'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if (null === $this->container['name']) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ((mb_strlen($this->container['name']) < 1)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be bigger than or equal to 1.";
        }

        if (null === $this->container['idList']) {
            $invalidProperties[] = "'idList' can't be null";
        }
        if ((mb_strlen($this->container['idList']) < 1)) {
            $invalidProperties[] = "invalid value for 'idList', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['contactId']) && ($this->container['contactId'] < 0)) {
            $invalidProperties[] = "invalid value for 'contactId', must be bigger than or equal to 0.";
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
     * Gets name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name.
     *
     * @param string $name Card Name
     *
     * @return $this
     */
    public function setName($name)
    {
        if ((mb_strlen($name) < 1)) {
            throw new \InvalidArgumentException('invalid length for $name when calling NewCard., must be bigger than or equal to 1.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets idList.
     *
     * @return string
     */
    public function getIdList()
    {
        return $this->container['idList'];
    }

    /**
     * Sets idList.
     *
     * @param string $idList The ID of the list the card should be created in
     *
     * @return $this
     */
    public function setIdList($idList)
    {
        if ((mb_strlen($idList) < 1)) {
            throw new \InvalidArgumentException('invalid length for $idList when calling NewCard., must be bigger than or equal to 1.');
        }

        $this->container['idList'] = $idList;

        return $this;
    }

    /**
     * Gets desc.
     *
     * @return string|null
     */
    public function getDesc()
    {
        return $this->container['desc'];
    }

    /**
     * Sets desc.
     *
     * @param string|null $desc Card Description
     *
     * @return $this
     */
    public function setDesc($desc)
    {
        $this->container['desc'] = $desc;

        return $this;
    }

    /**
     * Gets pos.
     *
     * @return string|null
     */
    public function getPos()
    {
        return $this->container['pos'];
    }

    /**
     * Sets pos.
     *
     * @param string|null $pos pos
     *
     * @return $this
     */
    public function setPos($pos)
    {
        $this->container['pos'] = $pos;

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
     * Gets urlSource.
     *
     * @return string|null
     */
    public function getUrlSource()
    {
        return $this->container['urlSource'];
    }

    /**
     * Sets urlSource.
     *
     * @param string|null $urlSource urlSource
     *
     * @return $this
     */
    public function setUrlSource($urlSource)
    {
        $this->container['urlSource'] = $urlSource;

        return $this;
    }

    /**
     * Gets contactId.
     *
     * @return int|null
     */
    public function getContactId()
    {
        return $this->container['contactId'];
    }

    /**
     * Sets contactId.
     *
     * @param int|null $contactId the ID of the Mautic contact (Lead)
     *
     * @return $this
     */
    public function setContactId($contactId)
    {
        if (!is_null($contactId) && ($contactId < 0)) {
            throw new \InvalidArgumentException('invalid value for $contactId when calling NewCard., must be bigger than or equal to 0.');
        }

        $this->container['contactId'] = $contactId;

        return $this;
    }

    /**
     * Gets keepFromSource.
     *
     * @return string|null
     */
    public function getKeepFromSource()
    {
        return $this->container['keepFromSource'];
    }

    /**
     * Sets keepFromSource.
     *
     * @param string|null $keepFromSource if using idCardSource you can specify which properties to copy over
     *
     * @return $this
     */
    public function setKeepFromSource($keepFromSource)
    {
        $this->container['keepFromSource'] = $keepFromSource;

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
