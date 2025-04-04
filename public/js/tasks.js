document.getElementById('taskForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const taskName = document.getElementById('taskName').value.trim();
    if (!taskName) return;

    try {
        // Виправлений POST-запит
        const response = await axios.post('/tasks', { name: taskName });

        const task = response.data.tasks;
        addTaskToList(task);

        document.getElementById('taskName').value = '';
    } catch (error) {
        console.error('Error adding task:', error);
    }
});

function addTaskToList(task) {
    const taskList = document.getElementById('taskList');

    const li = document.createElement('li');
    li.setAttribute('data-id', task.id);

    const span = document.createElement('span');
    span.textContent = task.name;

    const editButton = document.createElement('button');
    editButton.textContent = 'Edit';
    editButton.addEventListener('click', () => editTask(task.id, span, li));

    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', () => deleteTask(task.id, li));

    li.appendChild(span);
    li.appendChild(editButton);
    li.appendChild(deleteButton);
    taskList.appendChild(li);
}

async function editTask(id, spanElement, liElement) {
    const newTaskName = prompt('Enter new task name:', spanElement.textContent);
    if (!newTaskName || newTaskName.trim() === '') return;

    try {
        const response = await axios.put(`/tasks/${id}`, { name: newTaskName.trim() });

        const updatedTask = response.data.tasks;
        spanElement.textContent = updatedTask.name;
    } catch (error) {
        console.error('Error editing task:', error);
    }
}

async function deleteTask(id, liElement) {
    if (!confirm('Are you sure you want to delete this task?')) return;

    try {
        await axios.delete(`/tasks/${id}`);
        liElement.remove();
    } catch (error) {
        console.error('Error deleting task:', error);
    }
}