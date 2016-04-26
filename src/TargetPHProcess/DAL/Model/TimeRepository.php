<?php


namespace TargetPHProcess\DAL\Model;


use TargetPHProcess\Models\Time;

class TimeRepository extends AbstractTargetProcessModel
{
    protected $model = Time::class;
    protected $modelEntity = 'Times';

    public function create(Time $time)
    {
        $data = json_encode($time->getTPObject());
        $time = $this->setPostData($data)->post();
        return $time;
    }
}