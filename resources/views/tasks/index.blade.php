<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 p-5">

    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">{{ $boards->name }} - Tasks</h2>

        <div class="grid grid-cols-3 gap-4">
            @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $status => $title)
                <div class="bg-white p-4 rounded-md shadow-md">
                    <h3 class="text-xl font-semibold mb-2">{{ $title }}</h3>
                    <div class="task-list min-h-[200px] p-2 bg-gray-50 rounded-md" data-status="{{ $status }}">
                        @foreach($tasks->where('status', $status) as $task)
                            <div class="task-item p-3 mb-2 bg-blue-500 text-white rounded-md cursor-grab" 
                                data-id="{{ $task->id }}">
                                <p class="font-bold">{{ $task->title }}</p>
                                <p class="text-sm">{{ $task->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let tasks = document.querySelectorAll('.task-item');
        let lists = document.querySelectorAll('.task-list');
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        tasks.forEach(task => {
            task.draggable = true;
            task.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('taskId', task.dataset.id);
            });
        });

        lists.forEach(list => {
            list.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            list.addEventListener('drop', async (e) => {
                e.preventDefault();
                let taskId = e.dataTransfer.getData('taskId');
                let newStatus = list.dataset.status;
                let taskElement = document.querySelector(`[data-id='${taskId}']`);
                list.appendChild(taskElement);

                // Kirim perubahan status ke backend
                await fetch(`/tasks/${taskId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                });
            });
        });
    });
    </script>

</body>
</html>
