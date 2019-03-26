<?php

namespace Home\Controller;


use Think\Controller;
use Think\Exception;

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
        if (IS_POST && !IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('post.id');
            $data['name'] = I('post.name');
            if (!$User->create($data)) {
                exit($User->getError());
            } else {
                dump($User->fetchSql(false)->add());
            }
        }
        if (IS_POST && IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('request.id');
            $data['name'] = I('request.name');
            if (!$User->create($data)) {
                $this->ajaxReturn(array('error' => $User->getError()));
            } else {
                try {
                    $data = $User->fetchSql(false)->add();
                }
                catch (Exception $exception){
                    $this->ajaxReturn(array('error'=>$exception));
                }
                $result['success'] = $User->find($data);
                $this->ajaxReturn($result);
            }
        }
    }
}