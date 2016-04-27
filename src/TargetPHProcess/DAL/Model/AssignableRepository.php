<?php


namespace TargetPHProcess\DAL\Model;


use TargetPHProcess\Models\Assignable;
use TargetPHProcess\Models\Comment;
use TargetPHProcess\Models\EntityState;
use TargetPHProcess\Models\Time;
use TargetPHProcess\Models\User;

class AssignableRepository extends TPModel
{
    protected $model = Assignable::class;
    protected $modelEntity = 'Assignables';

    public function assignTo(User $user)
    {
       
    }

    public function postComment(Comment $comment)
    {

    }

    public function moveTo(EntityState $state)
    {

    }

    public function postTime(Time $time)
    {

    }
}