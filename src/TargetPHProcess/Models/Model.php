<?php


namespace TargetPHProcess\Models;

abstract class Model
{
    /** @var int */
    public $Id;

    public function getJsonData()
    {
        $data = get_object_vars($this);
        $arrayData = [];
        foreach ($data as $key => $value) {
            if ($value != null) {
                if (is_a($value, Model::class)) {
                    /** @var $value Model */
                    $arrayData[$key] = (object)$value->getJsonData();
                } else {
                    $arrayData[$key] = $value;
                }
            }
        }
        return $arrayData;
    }
}