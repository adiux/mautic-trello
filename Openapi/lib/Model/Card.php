<?php
/**
 * Card
 *
 * PHP version 5
 *
 * @category Class
 * @package  MauticPlugin\Idea2TrelloBundle\Openapi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Idea2 Trello API
 *
 * Create or update a card via the Trello API
 *
 * The version of the OpenAPI document: 0.1.1
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.1.2
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace MauticPlugin\Idea2TrelloBundle\Openapi\Model;

use \ArrayAccess;
use \MauticPlugin\Idea2TrelloBundle\Openapi\ObjectSerializer;

/**
 * Card Class Doc Comment
 *
 * @category Class
 * @package  MauticPlugin\Idea2TrelloBundle\Openapi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class Card implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Card';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'name' => 'string',
        'id_list' => 'string',
        'desc' => 'string',
        'pos' => 'string',
        'due' => '\DateTime',
        'url_source' => 'string',
        'keep_from_source' => 'string',
        'id' => 'string',
        'labels' => 'object[]',
        'url' => 'string',
        'date_last_activity' => '\DateTime',
        'id_members' => 'string',
        'attachments' => 'object[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPIFormats = [
        'name' => null,
        'id_list' => null,
        'desc' => null,
        'pos' => null,
        'due' => 'date-time',
        'url_source' => 'uri',
        'keep_from_source' => null,
        'id' => null,
        'labels' => null,
        'url' => 'uri',
        'date_last_activity' => 'date-time',
        'id_members' => null,
        'attachments' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'name' => 'name',
        'id_list' => 'idList',
        'desc' => 'desc',
        'pos' => 'pos',
        'due' => 'due',
        'url_source' => 'urlSource',
        'keep_from_source' => 'keepFromSource',
        'id' => 'id',
        'labels' => 'labels',
        'url' => 'url',
        'date_last_activity' => 'dateLastActivity',
        'id_members' => 'idMembers',
        'attachments' => 'attachments'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'name' => 'setName',
        'id_list' => 'setIdList',
        'desc' => 'setDesc',
        'pos' => 'setPos',
        'due' => 'setDue',
        'url_source' => 'setUrlSource',
        'keep_from_source' => 'setKeepFromSource',
        'id' => 'setId',
        'labels' => 'setLabels',
        'url' => 'setUrl',
        'date_last_activity' => 'setDateLastActivity',
        'id_members' => 'setIdMembers',
        'attachments' => 'setAttachments'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'name' => 'getName',
        'id_list' => 'getIdList',
        'desc' => 'getDesc',
        'pos' => 'getPos',
        'due' => 'getDue',
        'url_source' => 'getUrlSource',
        'keep_from_source' => 'getKeepFromSource',
        'id' => 'getId',
        'labels' => 'getLabels',
        'url' => 'getUrl',
        'date_last_activity' => 'getDateLastActivity',
        'id_members' => 'getIdMembers',
        'attachments' => 'getAttachments'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
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

    const POS_TOP = 'top';
    const POS_BOTTOM = 'bottom';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getPosAllowableValues()
    {
        return [
            self::POS_TOP,
            self::POS_BOTTOM,
        ];
    }
    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['id_list'] = isset($data['id_list']) ? $data['id_list'] : null;
        $this->container['desc'] = isset($data['desc']) ? $data['desc'] : null;
        $this->container['pos'] = isset($data['pos']) ? $data['pos'] : null;
        $this->container['due'] = isset($data['due']) ? $data['due'] : null;
        $this->container['url_source'] = isset($data['url_source']) ? $data['url_source'] : null;
        $this->container['keep_from_source'] = isset($data['keep_from_source']) ? $data['keep_from_source'] : null;
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['labels'] = isset($data['labels']) ? $data['labels'] : null;
        $this->container['url'] = isset($data['url']) ? $data['url'] : null;
        $this->container['date_last_activity'] = isset($data['date_last_activity']) ? $data['date_last_activity'] : null;
        $this->container['id_members'] = isset($data['id_members']) ? $data['id_members'] : null;
        $this->container['attachments'] = isset($data['attachments']) ? $data['attachments'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ((mb_strlen($this->container['name']) < 1)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['id_list'] === null) {
            $invalidProperties[] = "'id_list' can't be null";
        }
        if ((mb_strlen($this->container['id_list']) < 1)) {
            $invalidProperties[] = "invalid value for 'id_list', the character length must be bigger than or equal to 1.";
        }

        $allowedValues = $this->getPosAllowableValues();
        if (!is_null($this->container['pos']) && !in_array($this->container['pos'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'pos', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['id'] === null) {
            $invalidProperties[] = "'id' can't be null";
        }
        if ((mb_strlen($this->container['id']) < 1)) {
            $invalidProperties[] = "invalid value for 'id', the character length must be bigger than or equal to 1.";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name Card Name
     *
     * @return $this
     */
    public function setName($name)
    {

        if ((mb_strlen($name) < 1)) {
            throw new \InvalidArgumentException('invalid length for $name when calling Card., must be bigger than or equal to 1.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets id_list
     *
     * @return string
     */
    public function getIdList()
    {
        return $this->container['id_list'];
    }

    /**
     * Sets id_list
     *
     * @param string $id_list The ID of the list the card should be created in
     *
     * @return $this
     */
    public function setIdList($id_list)
    {

        if ((mb_strlen($id_list) < 1)) {
            throw new \InvalidArgumentException('invalid length for $id_list when calling Card., must be bigger than or equal to 1.');
        }

        $this->container['id_list'] = $id_list;

        return $this;
    }

    /**
     * Gets desc
     *
     * @return string|null
     */
    public function getDesc()
    {
        return $this->container['desc'];
    }

    /**
     * Sets desc
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
     * Gets pos
     *
     * @return string|null
     */
    public function getPos()
    {
        return $this->container['pos'];
    }

    /**
     * Sets pos
     *
     * @param string|null $pos pos
     *
     * @return $this
     */
    public function setPos($pos)
    {
        $allowedValues = $this->getPosAllowableValues();
        if (!is_null($pos) && !in_array($pos, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'pos', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['pos'] = $pos;

        return $this;
    }

    /**
     * Gets due
     *
     * @return \DateTime|null
     */
    public function getDue()
    {
        return $this->container['due'];
    }

    /**
     * Sets due
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
     * Gets url_source
     *
     * @return string|null
     */
    public function getUrlSource()
    {
        return $this->container['url_source'];
    }

    /**
     * Sets url_source
     *
     * @param string|null $url_source url_source
     *
     * @return $this
     */
    public function setUrlSource($url_source)
    {
        $this->container['url_source'] = $url_source;

        return $this;
    }

    /**
     * Gets keep_from_source
     *
     * @return string|null
     */
    public function getKeepFromSource()
    {
        return $this->container['keep_from_source'];
    }

    /**
     * Sets keep_from_source
     *
     * @param string|null $keep_from_source If using idCardSource you can specify which properties to copy over.
     *
     * @return $this
     */
    public function setKeepFromSource($keep_from_source)
    {
        $this->container['keep_from_source'] = $keep_from_source;

        return $this;
    }

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id id
     *
     * @return $this
     */
    public function setId($id)
    {

        if ((mb_strlen($id) < 1)) {
            throw new \InvalidArgumentException('invalid length for $id when calling Card., must be bigger than or equal to 1.');
        }

        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets labels
     *
     * @return object[]|null
     */
    public function getLabels()
    {
        return $this->container['labels'];
    }

    /**
     * Sets labels
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
     * Gets url
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->container['url'];
    }

    /**
     * Sets url
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
     * Gets date_last_activity
     *
     * @return \DateTime|null
     */
    public function getDateLastActivity()
    {
        return $this->container['date_last_activity'];
    }

    /**
     * Sets date_last_activity
     *
     * @param \DateTime|null $date_last_activity full-date notation as defined by RFC 3339, section 5.6. Default Timezone is UTC
     *
     * @return $this
     */
    public function setDateLastActivity($date_last_activity)
    {
        $this->container['date_last_activity'] = $date_last_activity;

        return $this;
    }

    /**
     * Gets id_members
     *
     * @return string|null
     */
    public function getIdMembers()
    {
        return $this->container['id_members'];
    }

    /**
     * Sets id_members
     *
     * @param string|null $id_members Comma-separated list of member IDs
     *
     * @return $this
     */
    public function setIdMembers($id_members)
    {
        $this->container['id_members'] = $id_members;

        return $this;
    }

    /**
     * Gets attachments
     *
     * @return object[]|null
     */
    public function getAttachments()
    {
        return $this->container['attachments'];
    }

    /**
     * Sets attachments
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
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
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
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
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
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
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
}


