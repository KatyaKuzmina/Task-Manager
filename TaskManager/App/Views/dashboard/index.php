<?php
$date = $_GET['date'] ?? date('Y-m-d');

$timestamp = strtotime($date);
$today = strtotime(date('Y-m-d'));

if ($timestamp === $today) {
    $label = 'Today';
} elseif ($timestamp === strtotime('-1 day', $today)) {
    $label = 'Yesterday';
} elseif ($timestamp === strtotime('+1 day', $today)) {
    $label = 'Tomorrow';
} else {
    $label = date('d.m.Y', $timestamp);
}
?>

<!DOCTYPE html>
<html lang="enenen">
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="/TaskManager/public/css/userPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Huninn&display=swap" rel="stylesheet">

</head>

<body>
    <div class="header-calendar">
        <div class="arrow">
            <button class="left-arrow" id="prev-day">
                <i class="fa fa-arrow-left fa-3x"></i>
            </button>
        </div>

        <div class="current-date">
            <p id="date-label"><?= htmlspecialchars($label) ?></p>
        </div>

        <div class="arrow">
            <button class="right-arrow" id="next-day">
                <i class="fa fa-arrow-right fa-3x"></i>
            </button>
        </div>
    </div>



    <?php

    if (isset($tasks)) {
        $labelTime = strtotime($label);

        $filtered = array_filter($tasks, function ($task) use ($labelTime) {
            $taskStarted = strtotime($task['date_started']);
            $taskTill = strtotime($task['date_till']);
            $isDone = $task['progress'] === 'done';

            if ($isDone && $taskTill < $labelTime) {
                return false;
            }

            return $taskStarted <= $labelTime;
        });

        $startedToday = array_filter($filtered, function ($task) use ($labelTime) {
            return strtotime($task['date_started']) === $labelTime;
        });

        $startedBefore = array_filter($filtered, function ($task) use ($labelTime) {
            return strtotime($task['date_started']) < $labelTime;
        });

        usort($startedToday, function ($a, $b) {
            return strtotime($a['date_till']) <=> strtotime($b['date_till']);
        });

        usort($startedBefore, function ($a, $b) {
            return strtotime($a['date_till']) <=> strtotime($b['date_till']);
        });

        $filteredTasks = array_merge($startedToday, $startedBefore);
    }
    ?>

    <div class="scroll-wrapper">
        <div class="task-container">

            <div class=progress-column-name>
                <div class="column-name">Upcoming</div>

                <div class="upcoming" data-status="upcoming">
                    <?php
                    $hasUpcoming = false;
                        foreach ($filteredTasks  as $task) {
                            if ($task['progress'] === 'upcoming') {
                                $hasUpcoming = true;
                                ?>
                                <div class="task clickable"
                                     draggable="true"
                                     data-id="<?= $task['id'] ?>"
                                     data-progress="<?= $task['progress'] ?>"
                                     data-name="<?= htmlspecialchars($task['name']) ?>"
                                     data-tag="<?= htmlspecialchars($task['tag']) ?>"
                                     data-descr="<?= htmlspecialchars($task['description']) ?>"
                                    data-start="<?= date('Y-m-d', strtotime($task['date_started'])) ?>"
                                    data-till="<?= date('Y-m-d', strtotime($task['date_till'])) ?>"
                                    data-color="<?= htmlspecialchars($task['color']) ?>">

									<?php if (!empty($task['tag'])): ?>
                                        <p class="task-tag" style="background-color: <?= htmlspecialchars($task['color'] ?? '#cccccc') ?>">
											<?= htmlspecialchars($task['tag']) ?>
                                        </p>
									<?php endif; ?>

                                    <p class="task-name"><?= htmlspecialchars($task['name']) ?></p>
                                    <p class="task-descr"><?= htmlspecialchars($task['description']) ?></p>
                                    <hr id="task-line">
                                    <p class="task-till-date">

                                        <?php
                                        $tillTime = strtotime($task['date_till']);
                                        $isOverdue = $tillTime <= $labelTime && $task['progress'] !== 'done';
                                        ?>

                                        <i class="fa fa-flag <?= $isOverdue ? 'overdue' : '' ?>" aria-hidden="true"></i>
                                        <?= date('M j', strtotime($task['date_till'])) ?>
                                    </p>
                                </div>
                                <?php
                            }
                    }

                    ?>
                </div>
            </div>

            <div class=progress-column-name>
                <div class="column-name">In progress</div>

                <div class="in-progress" data-status="in_progress">
                    <?php
                    $inProgress = false;
                        foreach ($filteredTasks  as $task) {
                            if ($task['progress'] === 'in_progress') {
                                $inProgress = true;
                                ?>
                                <div class="task clickable"
                                    draggable="true"
                                    data-id="<?= $task['id'] ?>"
                                    data-progress="<?= $task['progress'] ?>"
                                    data-name="<?= htmlspecialchars($task['name']) ?>"
                                    data-tag="<?= htmlspecialchars($task['tag']) ?>"
                                    data-descr="<?= htmlspecialchars($task['description']) ?>"
                                    data-start="<?= date('Y-m-d', strtotime($task['date_started'])) ?>"
                                    data-till="<?= date('Y-m-d', strtotime($task['date_till'])) ?>"
                                    data-color="<?= htmlspecialchars($task['color']) ?>" >


									<?php if (!empty($task['tag'])): ?>
                                        <p class="task-tag" style="background-color: <?= htmlspecialchars($task['color'] ?? '#cccccc') ?>">
											<?= htmlspecialchars($task['tag']) ?>
                                        </p>
									<?php endif; ?>

                                    <p class="task-name"><?= htmlspecialchars($task['name']) ?></p>
                                    <p class="task-descr"><?= htmlspecialchars($task['description']) ?></p>
                                    <hr id="task-line">
                                    <p class="task-till-date">
                                        <?php
                                        $tillTime = strtotime($task['date_till']);
                                        $isOverdue = $tillTime < $labelTime && $task['progress'] !== 'done';
                                        ?>
                                        <i class="fa fa-flag <?= $isOverdue ? 'overdue' : '' ?>" aria-hidden="true"></i>
                                        <?= date('M j', strtotime($task['date_till'])) ?>
                                    </p>
                                </div>
                                <?php
                            }
                    }
                    ?>
                </div>
            </div>

            <div class=progress-column-name>
                <div class="column-name">Done</div>

                <div class="done" data-status="done">
                    <?php
                    $done = false;
                    foreach ($filteredTasks  as $task) {
                        if ($task['progress'] === 'done') {
                            $done = true;
                            ?>
                            <div class="task clickable"
                                 draggable="true"
                                 data-id="<?= $task['id'] ?>"
                                 data-progress="<?= $task['progress'] ?>"
                                 data-name="<?= htmlspecialchars($task['name']) ?>"
                                 data-tag="<?= htmlspecialchars($task['tag']) ?>"
                                 data-descr="<?= htmlspecialchars($task['description']) ?>"
                                 data-start="<?= date('Y-m-d', strtotime($task['date_started'])) ?>"
                                data-till="<?= date('Y-m-d', strtotime($task['date_till'])) ?>"
                                data-color="<?= htmlspecialchars($task['color']) ?>">

								<?php if (!empty($task['tag'])): ?>
                                    <p class="task-tag" style="background-color: <?= htmlspecialchars($task['color'] ?? '#cccccc') ?>">
										<?= htmlspecialchars($task['tag']) ?>
                                    </p>
								<?php endif; ?>

                                <p class="task-name"><?= htmlspecialchars($task['name']) ?></p>
                                <p class="task-descr"><?= htmlspecialchars($task['description']) ?></p>
                                <hr id="task-line">
                                <p class="task-till-date">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                    <?= date('M j', strtotime($task['date_till'])) ?>
                                </p>
                            </div>
                            <?php
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="task-modal" class="modal hidden">
        <div class="modal-content">
            <span class="close-button" id="close-task-modal">&times;</span>
            <h3 id="modal-title">Task</h3>

            <form class="edit-form" id="task-form">
                <input type="hidden" name="id" id="task-id">

                <label for="task-name">Name:</label>
                <input type="text" name="name" id="task-name">

                <label for="task-tag">Tag:</label>
                <input type="text" name="tag" id="task-tag">

                <label for="task-descr">Description:</label>
                <textarea name="description" id="task-descr"></textarea>

                <label for="task-start">Start date:</label>
                <input type="date" name="date_started" id="task-start">

                <label for="task-till">Date till:</label>
                <input type="date" name="date_till" id="task-till">

                <label for="task-color">Color:</label>
                <input type="color" name="color" id="task-color" value="#ffffff">

                <button type="submit" id="task-submit-btn">Save</button>
                <button type="button" id="task-delete-btn" style="display: none;">Delete</button>

            </form>
        </div>
    </div>


</body>
</html>

<script>
    const labelEl = document.getElementById('date-label');
    const baseUrl = window.location.pathname;

    let currentDate = new Date("<?= $date ?>");

    document.getElementById('prev-day').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() - 1);
        window.location.href = `${baseUrl}?date=${currentDate.toISOString().split('T')[0]}`;
    });

    document.getElementById('next-day').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() + 1);
        window.location.href = `${baseUrl}?date=${currentDate.toISOString().split('T')[0]}`;
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.task.clickable').forEach(task => {
            task.addEventListener('dragstart', function (e) {
                e.dataTransfer.setData('text/plain', this.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                this.classList.add('dragging');
            });

            task.addEventListener('dragend', function () {
                this.classList.remove('dragging');
            });
        });

        document.querySelectorAll('[data-status]').forEach(column => {
            column.addEventListener('dragover', function (e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });

            column.addEventListener('drop', function (e) {
                e.preventDefault();
                const taskId = e.dataTransfer.getData('text/plain');
                const draggedTask = document.querySelector(`.task[data-id="${taskId}"]`);
                const newStatus = this.getAttribute('data-status');

                if (!draggedTask) return;

                this.appendChild(draggedTask);
                draggedTask.setAttribute('data-progress', newStatus);
                draggedTask.classList.remove('dragging');

                fetch('/TaskManager/public/update-progress.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: taskId,
                        progress: newStatus
                    })
                })
                    .then(res => {
                        if (!res.ok) throw new Error("Error.");
                    })
                    .catch(err => {
                        alert(err.message);
                    });
            });
        });
    });
</script>


