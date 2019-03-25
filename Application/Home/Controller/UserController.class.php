<?php

namespace Home\Controller;


use Think\Controller;

class UserController extends Controller
{
    public function read()
    {
        $User = D('Users');
        $arg['id'] = array('GT', I('get.id'));
        $user = $User->where($arg)->find();

        dump($user);
    }

    public function create()
    {
        return $this->display();
    }

    public function save()
    {
        if (IS_POST) {
            $User = D('Users');
            $data['id'] = I('post.id');
            $data['name'] = I('post.name');
            if (!$User->create($data)) {
                exit($User->getError());
            } else {
                dump($User->fetchSql(false)->add());
            }
        }
        if (IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('request.id');
            $data['name'] = I('request.name');
            if (!$User->create($data)) {
                $this->ajaxReturn($User->getError());
            } else {
                $result['result'] = $User->fetchSql(false)->add();
                $this->ajaxReturn($result);
            }
        }
    }
}