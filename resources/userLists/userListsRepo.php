<?php
namespace HawksNestGolf\Resources\UserLists;

Class UserListsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {

    public function __construct($dbInstance) {
        parent::__construct($dbInstance->UserLists);
    }
}
