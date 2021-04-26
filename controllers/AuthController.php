<?php

namespace controllers;

use components\App;
use components\Request;
use components\Session;
use components\Ui;
use components\Validator;
use models\User;
use rules\Email;
use rules\Required;

class AuthController extends Controller
{
    public function showLoginForm(): void
    {
        if (Session::has('user')) {
            App::$request->redirect('/tasks');
        }

        $this->view('auth/login');
    }
    public function registration(): void
    {
        if (Session::has('user')) {
            App::$request->redirect('/tasks');
        }

        $this->view('auth/registration');
    }
    public function registrationAuth(){
        if (Session::has('user')) {
            App::$request->redirect('/tasks');
        } 

        $validator = new Validator([
            'email'  => [
                new Required(App::$request->post('email')),
                new Email(App::$request->post('email'))
            ],
            'password' => [
                new Required(App::$request->post('password')),
            ],
            'name' => [
                new Required(App::$request->post('name')),
            ],
            'surname' => [
                new Required(App::$request->post('surname')),
            ]
        ]);

        $user = new User;
        $user->setAttribute('name', App::$request->post('name'));
        $user->setAttribute('surname', App::$request->post('name'));
        $user->setAttribute('email', App::$request->post('email'));
        $user->setAttribute('password', password_hash(App::$request->post('password'),PASSWORD_DEFAULT));
        $user->save();
        App::$request->redirect('/login');

    }
    public function auth(): void
    {
        if (Session::has('user')) {
            App::$request->redirect('/tasks');
        }

        $validator = new Validator([
            'email'  => [
                new Required(App::$request->post('email')),
                new Email(App::$request->post('email'))
            ],
            'password' => [
                new Required(App::$request->post('password')),
            ]
        ]);

        if ($validator->validate()) {
            $user = new User;
            $user
                ->select('*')
                ->where('email', '=', App::$request->post('email'))
                ->first();

            if ($user->hasAttributes() && password_verify(App::$request->post('password'), $user->getAttribute('password'))) {
                Session::store('user', [
                    'id' => $user->getAttribute('id'),
                ]);

                Ui::alert('success', 'You are logged in success!');
                App::$request->redirect('/tasks');
            } else {
                Ui::alert('errors', ['Invalid email or password!']);
                App::$request->redirect(
                    App::$request->referrer()
                );
            }
        } else {
            Ui::alert('errors', $validator->errors());
            App::$request->redirect('/login');
        }

    }

    public function logout(): void
    {
        if (Session::has('user')) {
            Session::remove('user');
        }

        App::$request->redirect('/tasks');
    }
}