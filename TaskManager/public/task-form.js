document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('task-modal');
    const closeBtn = document.getElementById('close-task-modal');
    const form = document.getElementById('task-form');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('task-submit-btn');
    const deleteBtn = document.getElementById('task-delete-btn');
    const openCreateBtn = document.getElementById('open-create-task');
    const tasks = document.querySelectorAll('.task.clickable');

    let isEditMode = false;
    let isSubmitting = false;

    if (openCreateBtn) {
        openCreateBtn.addEventListener('click', e => {
            e.preventDefault();
            isEditMode = false;
            title.textContent = 'Create Task';
            form.reset();
            document.getElementById('task-id').value = '';
            deleteBtn.style.display = 'none';
            modal.style.display = 'flex';
        });
    }

    tasks.forEach(task => {
        task.addEventListener('click', () => {
            isEditMode = true;
            title.textContent = 'Edit Task';

            document.getElementById('task-id').value = task.dataset.id;
            document.getElementById('task-name').value = task.dataset.name;
            document.getElementById('task-tag').value = task.dataset.tag;
            document.getElementById('task-descr').value = task.dataset.descr;
            document.getElementById('task-start').value = task.dataset.start;
            document.getElementById('task-till').value = task.dataset.till;
            document.getElementById('task-color').value = task.dataset.color;

            deleteBtn.style.display = 'inline';

            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', e => {
        if (e.target === modal) modal.style.display = 'none';
    });

    form.addEventListener('submit', e => {
        e.preventDefault();

        console.log("Form submission triggered");

        if (isSubmitting) {
            console.log("Form already submitting, skipping...");
            return;
        }
        isSubmitting = true;

        const formData = new FormData(form);
        const url = isEditMode ? '/TaskManager/public/update-task.php' : '/TaskManager/public/create-task.php';

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(res => {
                if (!res.ok) throw new Error('Failed to submit');
                return res.text();
            })
            .then(() => {
                modal.style.display = 'none';
                location.reload();
            })
            .catch(err => alert(err.message))
            .finally(() => {
                isSubmitting = false;
                console.log("Form submission completed");
            });
    });

    deleteBtn.addEventListener('click', () => {
        const taskId = document.getElementById('task-id').value;

        if (!taskId) return;

        const confirmDelete = confirm("Are you sure you want to delete this task?");
        if (!confirmDelete) return;

        const formData = new FormData();
        formData.append('id', taskId);

        fetch('/TaskManager/public/delete-task.php', {
            method: 'POST',
            body: formData
        })
            .then(res => {
                if (!res.ok) throw new Error('Failed to delete task');
                return res.text();
            })
            .then(() => {
                modal.style.display = 'none';
                location.reload();
            })
            .catch(err => alert(err.message));
    });
});
