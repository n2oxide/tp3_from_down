<?php

namespace Home\Controller;


use http\Client\Curl\User;
use Think\Controller;
use Think\Exception;

class UserController extends Controller
{
    public function read()
    {
        $User = D('Users');
        $arg['id'] = array('EQ', I('get.id'));
        $user = $User->where($arg)->find();

        dump($user);
    }

    public function index()
    {
        $User = D('Users');
        $users = $User->select();
        $this->assign('users', $users);
        $this->display();
    }

    //新增用户页面
    public function create()
    {
        $this->display();
    }

    //新增用户
    public function save()
    {
        //表单提交途径
        if (IS_POST && !IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('post.id');
            $data['name'] = I('post.name');
            //自动验证，完成
            if (!$User->create($data)) {
                exit($User->getError());
            } else {
                $id = $User->fetchSql(false)->add();
                $user = $User->find($id);
                dump($user);
            }
        }
        //AJAX提交途径
        if (IS_POST && IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('request.id');
            $data['name'] = I('request.name');
            //自动验证，完成
            if (!$User->create($data)) {
                $this->error(array('error' => $User->getError()));
            } else {
                //抛出PDO错误
                //在使用ajax时，如果不捕捉错误，将会得到404页面响应
                try {
                    $data = $User->fetchSql(false)->add();
                } catch (Exception $exception) {
                    $this->error(array('error' => $exception));
                }
                //成功并返回用户信息
                $result['success'] = $User->find($data);
                $this->success($result);
            }
        }
    }

    //编辑用户页面
    public function edit()
    {
        $user = D('Users')->find(I('get.id'));

        if ($user !== false && !empty($user)) {
            $this->assign('user', $user);
            $this->display();
        } else {
            dump('用户不存在');
        }
    }

    //编辑用户
    public function update()
    {
        $User = D('Users');
        if (IS_POST && !IS_AJAX) {
            if (!$User->create()) {
                dump($User->getError());
            }


            $other['age'] = array('gt', 1);
            //重写主键条件，否则在附加条件采取'='之外的条件时，
            //会产生1062:Duplicate entry '2' for key 'PRIMARY'
            //[ SQL语句 ] : UPDATE `users` SET `id`='2',`name`='sec ladys' WHERE `age` > 1
            //这应该是mysql本身的错误，若全是=条件，会自动将set id=2编译为 where id =2
            $other['id'] = array('eq', 2);

            $result = $User->where($other)->field(array('age', 'name'))->save();
            if ($result !== false) {
                dump('success' . $result);
            }

            dump($User->getDbError());
            dump($User->getLastSql());
        }
    }

    public function delete()
    {
        $User = D('Users');
        $data['id'] = I('get.id');


        if (!$User->create($data)) {
            dump($User->getError());
        }
        //以下用法会取表第一行数据，在数据读取中，必须用where显式指定条件
        //$user = $User->find();
        $user = $User->where($data)->find();

        //查询出错
        if ($user === false) {
            dump($User->getDbError());
            dump($User->getLastSql());
        }
        //待删除用户实际不存在
        if (empty($user)) {
            dump('无此用户');
        }
        //删除用户
        if ($user !== false && !empty($user)) {
            dump($User->fetchSql(true)->delete());
        }
    }
}