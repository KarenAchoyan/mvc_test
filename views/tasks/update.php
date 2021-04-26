<?php

/**
 * @var Task $task
 */

use components\Session;
use models\Task; ?>

<div class="container">
    <div class="row">

        <?php if (Session::has('errors')): ?>
            <ul class="alert alert-danger col-12">
                <?php foreach (Session::get('errors') as $message): ?>
                    <li class="ml-2"><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>


        <form action="/tasks/update" method="post" class="col-12">
            <input type="hidden" value="<?= $task->getAttribute('id') ?>" name="id">
            <div class="form-group">
                <label for="task">Text</label>
                <textarea class="form-control" id="task" rows="3" placeholder="Enter task" name="task"><?= $task->getAttribute('text') ?></textarea>
            </div>
            <div class="form-group">
                <label for="completed">Completed</label>
                <input type="checkbox" class="form-control" id="completed" name="completed" <?= $task->getAttribute('completed') ? 'checked' : '' ?>>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>