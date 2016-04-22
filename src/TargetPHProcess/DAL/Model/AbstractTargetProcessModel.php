<?php


namespace TargetPHProcess\DAL\Model;


use anlutro\cURL\cURL;
use TargetPHProcess\BLL\Configuration\Configuration;
use TargetPHProcess\Exceptions\NoModelSetException;
use TargetPHProcess\SystemConfiguration\ProjectConfiguration;

abstract class AbstractTargetProcessModel
{
    /** @var string */
    protected $query;
    /** @var string */
    protected $includeAttributes;
    /** @var string */
    protected $excludeAttributes;
    /** @var string */
    protected $format = 'json';
    /** @var string */
    protected $model = null;
    /** @var int */
    protected $take;
    /** @var int */
    protected $skip;
    /** @var string */
    protected $data;
    /** @var int */
    protected $id;

    /** @var ProjectConfiguration */
    protected $configuration;
    /* @var cURL */
    private $curl;

    public function __construct(cURL $curl)
    {
        $this->configuration = Configuration::getInstance()->getProjectConfiguration();
        $this->curl = $curl;
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
        $this->query = $query;
        return $this;
    }

    public function includeAttributes($attributes)
    {
        $this->includeAttributes = $attributes;
        return $this;
    }

    public function excludeAttributes($attributes)
    {
        $this->excludeAttributes = $attributes;
        return $this;
    }

    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function format($format)
    {
        $this->format = $format;
        return $this;
    }

    public function skip($value)
    {
        $this->skip = $value;
        return $this;
    }

    public function take($value)
    {
        $this->take = $value;
        return $this;
    }

    public function postData($data)
    {
        $this->data = $data;
    }

    public function get()
    {
        $url = $this->constructQuery();
        $response = $this->curl->get($url);
        return $response;
    }

    public function post()
    {
        $url = $this->constructQuery();
        $data = $this->data;
        $response = $this->curl->post($url, $data);
        return $response;
    }

    private function constructQuery()
    {
        if (empty($this->model)) {
            throw new NoModelSetException();
        }

        $url = "{$this->configuration->tp_url}/api/v1/{$this->model}";
       
        # Add ID
        if (!empty($this->id)) {
            $url .= "/{$this->id}";
        }

        # Add format
        $url .= "?format={$this->format}";

        if (!empty($this->includeAttributes)) {
            $url .= "&include={$this->includeAttributes}";
        }
        if (!empty($this->excludeAttributes)) {
            $url .= "&exclude={$this->excludeAttributes}";
        }
        if (!empty($this->take)) {
            $url .= "&take={$this->take}";
        }
        if (!empty($this->skip)) {
            $url .= "&skip={$this->skip}";
        }
        return $url;
    }

    public abstract function find($id);
}