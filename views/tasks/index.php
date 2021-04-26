<?php

/**
 * @var array $tasks
 * @var Task $task
 * @var array $pagination
 * @var string $orderDirection
 */

use components\Session;
use models\Task;
use components\App;

?>

<?php if (Session::has('errors')): ?>
    <ul class="alert alert-danger col-12">
        <?php foreach (Session::get('errors') as $message): ?>
            <li class="ml-2"><?= $message ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (Session::has('success')): ?>
    <div class="alert alert-success col-12 text-center">
        <?= Session::get('success') ?>
    </div>
<?php endif ?>

<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">ID <a href="/tasks?<?= http_build_query(array_merge(App::$request->all(), ['sort' => 'id,' . $orderDirection])) ?>"><i class="fa fa-fw fa-sort"></i></a></th>
        <th scope="col">User <a href="/tasks?<?= http_build_query(array_merge(App::$request->all(), ['sort' => 'name,' . $orderDirection])) ?>"><i class="fa fa-fw fa-sort"></i></a></th>
        <th scope="col">Text <a href="/tasks?<?= http_build_query(array_merge(App::$request->all(), ['sort' => 'text,' . $orderDirection])) ?>"><i class="fa fa-fw fa-sort"></i></a></th>
        <th scope="col">Completed <a href="/tasks?<?= http_build_query(array_merge(App::$request->all(), ['sort' => 'completed,' . $orderDirection])) ?>"><i class="fa fa-fw fa-sort"></i></a></th>
        <th scope="col">Modified by admin <a href="/tasks?<?= http_build_query(array_merge(App::$request->all(), ['sort' => 'modified,' . $orderDirection])) ?>"><i class="fa fa-fw fa-sort"></i></a></th>
        <?php if (Session::has('user')): ?>
        <th scope="col">Action</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task->getAttribute('id') ?></td>
            <td><?= $task->getAttribute('name') ?></td>
            <td><?= $task->getAttribute('text') ?></td>
            <td><?= $task->getAttribute('completed') ? 'Yes' : 'No' ?></td>
            <td><?= $task->getAttribute('modified') ? 'Yes' : 'No' ?></td>
            <?php if (Session::has('user')): ?>
                <td>
                    <a class="btn btn-primary" href="/tasks/edit?id=<?= $task->getAttribute('id') ?>">Edit</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $pagination['links']; $i++): ?>
            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge(App::$request->all(), ['page' => $i])) ?>"><?= $i ?></a></li>
        <?php endfor;?>
    </ul>
</nav>