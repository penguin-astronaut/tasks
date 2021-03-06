<?php
/** @var array $tasksList This is array of task. */
/** @var string $error This is form error message form. */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Tasks</title>
</head>
<body>
<div class="wrapper">
    <h1>Tasks list</h1>
    <div class="tasks-actions">
        <div class="new-task">
            <form class="new-task__form" method="post" action="/index.php">
                <input class="input new-task__input" type="text" name="text" placeholder="Enter text...">
                <button class="button button--filled">add task</button>
            </form>
            <?php if ($error): ?>
                <p class="new-task__error"><?=$error?></p>
            <?php endif; ?>
        </div>
        <div class="tasks-actions__buttons">
            <a href="/actions.php?action=remove_all" class="button">remove all</a>
            <a href="/actions.php?action=ready_all" class="button">ready all</a>
        </div>

    </div>

    <div class="tasks">
        <?php foreach ($tasksList as $task): ?>
            <div class="task">
                <div class="task__content">
                    <div class="task__text"><?= $task['description']; ?></div>
                    <div class="task-actions">
                        <a href="/actions.php?action=remove&id=<?= $task['id']; ?>" class="button">remove</a>
                        <?php if ($task['status'] == Tasks::STATUS_READY): ?>
                            <a href="/actions.php?action=change_status&status=unready&id=<?= $task['id']; ?>" class="button">unready</a>
                        <?php else: ?>
                            <a href="/actions.php?action=change_status&status=ready&id=<?= $task['id']; ?>" class="button">ready</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="task__status<?= $task['status'] !== Tasks::STATUS_READY ? '' : ' task__status--ready' ?>">
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>