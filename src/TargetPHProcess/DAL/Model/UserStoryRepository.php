<?php


namespace TargetPHProcess\DAL\Model;


use TargetPHProcess\Models\UserStory;

class UserStoryRepository extends AssignableRepository
{
    protected $model = UserStory::class;
    protected $modelEntity = 'UserStories';
}