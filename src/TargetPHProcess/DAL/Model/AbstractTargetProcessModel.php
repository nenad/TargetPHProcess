<?php


namespace TargetPHProcess\DAL\Model;


use anlutro\cURL\cURL;
use JsonMapper;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\Exceptions\NoModelSetException;
use TargetPHProcess\Models\Model;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

abstract class AbstractTargetProcessModel
{
    /** @var string */
    protected $query;
    /** @var array */
    protected $includeAttributes;
    /** @var array */
    protected $excludeAttributes;
    /** @var string */
    protected $format = 'json';
    /** @var Model */
    protected $model = null;
    /** @var string */
    protected $modelEntity = null;
    /** @var int */
    protected $take;
    /** @var int */
    protected $skip;
    /** @var string */
    protected $postData;
    /** @var int */
    protected $id;
    /** @var array */
    protected $data = [];

    /** @var ProjectConfiguration */
    protected $configuration;
    /* @var cURL */
    private $curl;
    /**
     * @var JsonMapper
     */
    protected $mapper;

    public function __construct(cURL $curl, JsonMapper $mapper)
    {
        $this->configuration = Configuration::getInstance()->getProjectConfiguration();
        $this->curl = $curl;
        $this->mapper = $mapper;
    }

    public function hasConfiguration()
    {
        return $this->configuration != null;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function setConfiguration(ProjectConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function query($query)
    {
        $this->data['query'] = $query;
        $this->query = $query;
        return $this;
    }

    public function includeAll()
    {
        $modelAttributes = array_keys(get_class_vars($this->model));
        $this->setIncludeAttributes($modelAttributes);
        return $this;
    }

    public function addIncludeAttributes(array $attributes)
    {
        $this->includeAttributes = array_unique(array_merge($this->includeAttributes, $attributes));
        $this->data['include'] = $this->wrapInBrackets($attributes);
        return $this;
    }

    public function addExcludeAttributes(array $attributes)
    {
        $this->excludeAttributes = array_unique(array_merge($this->excludeAttributes, $attributes));
        $this->data['exclude'] = $this->wrapInBrackets($attributes);
        return $this;
    }

    public function setIncludeAttributes(array $attributes)
    {
        $this->includeAttributes = $attributes;
        $this->data['include'] = $this->wrapInBrackets($attributes);
        return $this;
    }

    public function setExcludeAttributes(array $attributes)
    {
        $this->excludeAttributes = $attributes;
        $this->data['exclude'] = $this->wrapInBrackets($attributes);
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFormat($format)
    {
        $this->data['format'] = $format;
        $this->format = $format;
        return $this;
    }

    public function setSkip($value)
    {
        $this->data['skip'] = $value;
        $this->skip = $value;
        return $this;
    }

    public function setTake($value)
    {
        $this->data['take'] = $value;
        $this->take = $value;
        return $this;
    }

    public function setPostData($data)
    {
        $this->postData = $data;
    }

    public function get()
    {
        $this->setFormat('json');
        $url = $this->constructQuery();
        $url = $this->curl->buildUrl($url, $this->data);
        $request = $this->curl->newRequest('GET', $url);
        $request->setHeader('Authorization', "Basic {$this->configuration->auth}");
        $response = $request->send();
        $json = $response->body;
        $mappedObject = $this->getMappedObject($json);

        if (is_array($mappedObject)) {
            return $this->mapper->mapArray($mappedObject, [], new $this->model);
        }

        return $this->mapper->map($mappedObject, new $this->model);
    }

    public function post()
    {
        $url = $this->constructQuery();
        $data = $this->postData;
        $response = $this->curl->post($url, $data);
        return $response;
    }

    private function constructQuery()
    {
        if (empty($this->modelEntity)) {
            throw new NoModelSetException();
        }

        $url = "{$this->configuration->tp_url}/api/v1/{$this->modelEntity}";

        # Add ID
        if (!empty($this->id)) {
            $url .= "/{$this->id}";
        }

        /**
         * # Add format
         * $url .= "?format={$this->format}";
         *
         * if (!empty($this->includeAttributes)) {
         * $url .= "&include={$this->includeAttributes}";
         * }
         * if (!empty($this->excludeAttributes)) {
         * $url .= "&exclude={$this->excludeAttributes}";
         * }
         * if (!empty($this->take)) {
         * $url .= "&take={$this->take}";
         * }
         * if (!empty($this->skip)) {
         * $url .= "&skip={$this->skip}";
         * }
         */
        return $url;
    }

    public function find($id)
    {
        return $this->setId($id)->includeAll()->get();
    }

    public function all($skip = 0, $take = 100)
    {
        return $this->setSkip($skip)->setTake($take)->get();
    }

    public function getMappedObject($json)
    {
        $jsonArray = json_decode($json, true);
        $normalizedArray = [];
        if (key_exists('Items', $jsonArray)) {
            return json_decode(json_encode($jsonArray['Items']));
        }
        foreach ($jsonArray as $key => $value) {
            if (is_array($value) and key_exists('Items', $value)) {
                $normalizedArray[$key] = $value['Items'];
            } else {
                $normalizedArray[$key] = $value;
            }
        }
        return json_decode(json_encode($normalizedArray));
    }

    public function wrapInBrackets(array $attributes)
    {
        $stringArray = '[';
        foreach ($attributes as $key => $attribute) {
            if (is_array($attribute)) {
                return $stringArray . $key . $this->wrapInBrackets($attribute);
            } else {
                $stringArray .= "{$attribute},";
            }
        }
        $stringArray = substr($stringArray, 0, -1);
        return $stringArray . ']';
    }
}