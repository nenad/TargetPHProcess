<?php


namespace Tests\DAL\Model;


use TargetPHProcess\DAL\Model\TPModel;

class TPTestModel extends TPModel
{
    protected $model = TestModel::class;
    protected $modelEntity = 'TestModels';
}