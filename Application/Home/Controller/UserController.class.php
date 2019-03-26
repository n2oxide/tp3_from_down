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

    //新增用户
    public function save()
    {
        //表单提交途径
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
        //AJAX提交途径
        if (IS_POST && IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('request.id');
            $data['name'] = I('request.name');
            if (!$User->create($data)) {
                $this->ajaxReturn(array('error' => $User->getError()));
            } else {
                //抛出PDO错误
                try {
                    $data = $User->fetchSql(false)->add();
                }
                catch (Exception $exception){
                    $this->ajaxReturn(array('error'=>$exception));
                }
                //成功并返回用户信息
                $result['success'] = $User->find($data);
                $this->ajaxReturn($result);
            }
        }
    }
}