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

        <form class="col-12" action="/login/auth" method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>