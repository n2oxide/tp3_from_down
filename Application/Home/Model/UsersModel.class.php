<?php

namespace Home\Model;

use Think\Model;

class UsersModel extends Model
{
    protected $_validate = array(
        array('id', 'number', 'id必须是数字', 3)
    );

    protected $_auto = array(
        array('name', 'name_add_s', 3, 'function')
    );
}