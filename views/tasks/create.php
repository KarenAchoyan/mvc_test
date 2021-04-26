<?php

use components\Session;
?>

<div class="container">
    <div class="row">

        <?php if (Session::has('errors')): ?>
            <ul class="alert alert-danger col-12">
                <?php foreach (Session::get('errors') as $message): ?>
                    <li class="ml-2"><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>


        <form action="/tasks/store" method="post" class="col-12">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
                <label for="task">Text</label>
                <textarea class="form-control" id="task" rows="3" placeholder="Enter task" name="task"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>