<?php


namespace Tests\DAL\Model;


use TargetPHProcess\DAL\Model\TPModel;

class TPTestRepo extends TPModel
{
    protected $model = TestModel::class;
    protected $modelEntity = 'TestModels';
}