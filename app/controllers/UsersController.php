<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 24/05/2017
 * Time: 9:01 SA
 */
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UsersController extends AuthenManagerRole
{
    public function addUser()
    {
        $view = View::make('add_user');
        $roles = new Role();
        $re_roles = $roles->getAll();
        $view->roles = $re_roles;
        $lake = new Lake(null);
        $re_lakes = $lake->getAll();
        $view->lakes = $re_lakes;
        unset($roles, $re_lakes, $re_roles, $lake);
        return $view;
    }

    public function usersManager()
    {
        $view = View::make('users_manager');
        $users = new User(null);
        $re_users = $users->getAll();
        $view->users = $re_users;
        unset($users, $re_users);
        return $view;
    }

    public function addUserAction()
    {
        $inputs = Input::all();
        $role = new Role();

        $code = $role->getRow(array('code' => $inputs['role']));
        $inputs['role_name'] = $code['role_name'];
        $re_lake = array();
        if (@$inputs['lake_id'] != '') {
            foreach ($inputs['lake_id'] as $id) {
                $str = explode('|', $id);
                $re_lake[$str[0]] = $str[1];
            }
        }
        $inputs['lake_id'] = $re_lake;
        $user = new User($inputs);
        $status = $user->insert();
        unset($role, $code, $inputs, $user, $re_lake, $str, $id);
        if ($status) {
            Session::flash('success_add_user', 'Thành công!');
        } else {
            Session::flash('error_add_user', 'Tên đăng nhập đã tồn tại!');
        }
        return Redirect::to('/add-user');
    }

    public function editUser()
    {
        $view = View::make('form_edit_user');
        $inputs = Input::all();
        $roles = new Role();
        $re_roles = $roles->getAll();
        $view->roles = $re_roles;
        $lake = new Lake(null);
        $re_lakes = $lake->getAll();
        $view->lakes = $re_lakes;

        $user = new User(null);
        $filter = array(
            'username' => @$inputs['username']
        );
        $re_user = $user->getRow($filter);

        unset($inputs, $roles, $re_roles, $re_lakes);
        if ($re_user == null) {
            return Redirect::to('/users-manager');
        } else {
            $user_lake = $re_user['lake_id'];
            $view->user_lake = $user_lake;
            $view->user = $re_user;
            return $view;
        }

    }

    public function editUserAction()
    {
        $inputs = Input::all();
        $new_data = array(
            'username' => $inputs['username'],
            'full_name' => $inputs['full_name'],
            'address' => $inputs['address'],
            'phone_number' => $inputs['phone_number'],
            'email' => $inputs['email'],
            'role' => $inputs['role'],
        );

        $re_lake = array();
        foreach ($inputs['lake_id'] as $id) {
            $str = explode('|', $id);
            $re_lake[$str[0]] = $str[1];
        }

        $new_data['lake_id'] = $re_lake;

        $role = new Role();
        $code = $role->getRow(array('code' => $inputs['role']));
        $new_data['role_name'] = $code['role_name'];
        $filter = array(
            'username'=>$inputs['username']
        );
        $user = new User(null);
        $user->update($filter, $new_data);
        unset($new_data, $re_lake, $str, $id, $filter, $code);
        Session::flash('success_add_user','Thành công!');
        return Redirect::to('/edit-user?username='.$inputs['username']);
    }

    public function profile()
    {
        $user = new User(null);
        $view = View::make('profile');
        $filter = array(
            'username' => Session::get('username')
        );
        $re_user = $user->getRow($filter);
        $view->user = $re_user;
        $roles = new Role();
        $re_roles = $roles->getAll();
        $view->roles = $re_roles;
        unset($user, $re_user, $re_roles);
        return $view;
    }

    public function editProfileAction()
    {
        $inputs = Input::all();
        $user = new User(null);
        $filter = array(
            'username' => Session::get('user.username')
        );
        $new_data = array();
        if (!empty($inputs['old_password']) || !empty($inputs['password'])) {
            $filter = array(
                'password' => md5($inputs['old_password'])
            );
            $re_user = $user->getRow($filter);
            if ($re_user != null) {
                $new_data = array(
                    'password' => md5($inputs['password'])
                );
                Session::flash('success_edit_user', 'Đổi mật khẩu thành công!');
            } else {
                Session::flash('error_edit_user', 'Mật khẩu không đúng!');
            }
        } else {
            $new_data = array(
                'full_name' => $inputs['full_name'],
                'address' => $inputs['address'],
                'phone_number' => $inputs['phone_number'],
                'email' => $inputs['email'],
                'role' => $inputs['role']
            );
            Session::flash('success_edit_user', 'Thành công!');
        }

        $user->update($filter, $new_data);
        unset($inputs, $user, $filter, $re_user, $new_data);
        return Redirect::to('/profile');
    }
}