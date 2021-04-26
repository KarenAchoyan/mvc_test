<?php

namespace controllers;

use components\App;
use components\Session;
use components\Ui;
use components\Validator;
use models\Task;
use models\User;
use rules\Email;
use rules\IsModifiedString;
use rules\Required;

class TaskController extends Controller
{
    public const PER_PAGE = 3;

    protected int $page;

    public function index(): void
    {

        $this->page = (int) App::$request->get('page') ?: 1;

        $task = new Task;

        $tasksCount = count(
            $task
                ->select('*')
                ->get()
        );
  
        $pagination = [
            'page'  => $this->page,
            'links' => (int) ceil($tasksCount / self::PER_PAGE)
        ];

        $sortQuery = explode(',', App::$request->get('sort'));

        $sortCredentials = [
            ! empty($sortQuery[0]) ? $sortQuery[0] : 'id',
            ! empty($sortQuery[1]) ? $sortQuery[1] : 'desc'
        ];

        $orderDirection = $sortCredentials[1] === 'desc' ? 'asc' : 'desc';

        $tasks = $task->select('tasks.id, users.name, tasks.text, tasks.completed, tasks.modified')
            ->join('users', 'tasks.user_id = users.id')
            ->orderBy($sortCredentials[0], $sortCredentials[1])
            ->limitOffset(($this->page - 1) * self::PER_PAGE, self::PER_PAGE)
            ->get();
       
        // if (!count($tasks)) {
        //     http_response_code(404);
        //     die;
        // }

        $this->view('tasks/index', [
            'tasks' => $tasks,
            'pagination' => $pagination,
            'orderDirection' => $orderDirection
        ]);
    }

    public function create(): void
    {
        $this->view('tasks/create');
    }
    
    public function store(): void
    {

        $validator = new Validator([
            'email'  => [
                new Required(App::$request->post('email')),
                new Email(App::$request->post('email'))
            ],
            'name' => [
                new Required(App::$request->post('name'))
            ],
            'text' => [
                new Required(App::$request->post('task'))
            ]
        ]);

        if ($validator->validate()) {

            $user = new User;
            $user->setAttribute('name', App::$request->post('name'));
            $user->setAttribute('email', App::$request->post('email'));
            $user->save();

            $task = new Task;
            $task->setAttribute('user_id', $user->getAttribute('id'));
            $task->setAttribute('text', App::$request->post('task'));
            $task->save();

            Ui::alert('success', 'Task successfully saved!');
            App::$request->redirect('/tasks');
        } else {
            Ui::alert('errors', $validator->errors());
            App::$request->redirect(
                App::$request->referrer()
            );
        }
    }

    public function edit()
    {
   

        $task = new Task;

        $this->view('tasks/update', [
            'task' => $task
                ->select('*')
                ->where('id', '=', App::$request->get('id'))
                ->first()
        ]);
    }

    public function update()
    {
     
        $task = new Task;
        $task
            ->select('*')
            ->where('id', '=', App::$request->post('id'))
            ->first();

        $validator = new Validator([
            'text' => [
                new Required(
                    $task->getAttribute('text'),
                    App::$request->post('task')
                )
            ]
        ]);

        if ($validator->validate()) {
            $task->setAttribute('completed', App::$request->post('completed') ? 1 : 0);
            $task->setAttribute('modified', 1);
            $task->setAttribute('text',  App::$request->post('task'));
            $task->update();

            Ui::alert('success', 'Task successfully updated!');
            App::$request->redirect('/tasks');
        } else {
            Ui::alert('errors', $validator->errors());
            App::$request->redirect(
                App::$request->referrer()
            );
        }
    }
}