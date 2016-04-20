<?php


namespace TargetPHProcess\DAL\Model;


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

    /** @var ProjectConfiguration */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = Configuration::getInstance()->getProjectConfiguration();
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

    }

    public function post()
    {

    }

    private function constructQuery()
    {
        if (empty($this->model)) {
            throw new NoModelSetException();
        }

        $url = $this->configuration->tp_url . '/api/v1/' . $this->model . '?';
        $url .= "format={$this->format}";

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
}