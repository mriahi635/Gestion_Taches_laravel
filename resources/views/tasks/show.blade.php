@extends('layouts.app')
@section('title')
    {{ $task->title }} - Task Details
@endsection
@section('content')
    <style>
        /* Global Styles */
        body {
            background-color: #f4f7fb; /* Trello-like background */
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Card Styling */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
        }

        .card-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #333;
        }

        .card-text {
            color: #666;
            font-size: 1rem;
        }

        /* Buttons */
        .btn {
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #0079bf; /* Trello blue */
            border-color: #0079bf;
        }

        .btn-primary:hover {
            background-color: #026aa7;
        }

        .btn-secondary {
            background-color: #ebecf0; /* Light gray for secondary */
            border-color: #ebecf0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #dfe1e6;
        }

        /* Checklist */
        .list-group-item {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-check-label {
            font-size: 1rem;
            color: #333;
        }

        .form-check-input:checked + .form-check-label {
            text-decoration: line-through;
            color: #6c757d;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        /* Time Tracker */
        #time-tracker {
            margin-top: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #f7f7f7;
            text-align: center;
        }

        #time-display {
            font-size: 2rem;
            font-weight: bold;
            color: #0079bf;
        }

        #start-btn, #pause-btn, #reset-btn {
            border-radius: 50%;
            padding: 10px 20px;
            margin: 5px;
            font-size: 1.2rem;
            transition: background-color 0.3s ease;
        }

        #start-btn {
            background-color: #36b37e; /* Play button color */
        }

        #start-btn:hover {
            background-color: #2a9f61;
        }

        #pause-btn {
            background-color: #ffab00; /* Pause button color */
        }

        #pause-btn:hover {
            background-color: #e79400;
        }

        #reset-btn {
            background-color: #ff5630; /* Stop button color */
        }

        #reset-btn:hover {
            background-color: #e04327;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 10px;
            padding: 20px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            display: flex;
            justify-content: flex-end;
        }

        .modal-body {
            padding: 15px;
        }
    </style>

    <div class="container">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white text-center">{{ $task->title }} - Task Details</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">{{ $task->title }}</h5>
                                <p class="card-text">{{ $task->description }}</p>
                                <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                <p class="card-text"><strong>Priority:</strong> <span
                                        class="badge {{ $task->priority == 'low' ? 'bg-info' : ($task->priority == 'medium' ? 'bg-primary' : 'bg-dark') }}">{{ ucfirst($task->priority) }}</span>
                                </p>
                                <p class="card-text"><strong>Status:</strong>
                                    @if ($task->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($task->status == 'to_do')
                                        <span class="badge bg-primary">To Do</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge bg-info">In Progress</span>
                                    @endif
                                </p>

                                <p class="card-text"><strong>Assign To:</strong> {{ $task->user->name }}</p>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editTaskModal"> <i class="bi bi-pencil-square"></i> </button>
                                <a href="{{ route('projects.tasks.index', $task->project->id) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-90deg-left"></i> </a>
                            </div>

                            <div class="col-md-6 border-start">
                                <h5>Time Tracker</h5>
                                <div id="time-tracker">
                                    <span id="time-display">00:00:00</span>
                                    <div>
                                        <button id="start-btn" class="btn btn-info btn-sm"><i
                                                class="bi bi-play-fill"></i></button>
                                        <button id="pause-btn" class="btn btn-warning btn-sm"><i
                                                class="bi bi-pause-fill"></i></button>
                                        <button id="reset-btn" class="btn btn-danger btn-sm"><i
                                                class="bi bi-stop-fill"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <h5>Checklist</h5>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addChecklistModal"> <i class="bi bi-plus-circle"></i> </button>
                                </div>

                                <!-- Checklist items -->
                                <ul class="list-group mt-2" id="checklist-items">
                                    @foreach ($task->checklistItems as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                            id="checklist-item-{{ $item->id }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="checklist-item-checkbox-{{ $item->id }}"
                                                    {{ $item->completed ? 'checked' : '' }}
                                                    onchange="toggleChecklistItem({{ $item->id }})">
                                                <label
                                                    class="form-check-label {{ $item->completed ? 'text-decoration-line-through' : '' }}">{{ $item->name }}</label>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editChecklistModal-{{ $item->id }}"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteChecklistItem({{ $item->id }})"><i
                                                        class="bi bi-trash"></i></button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Checklist Modal -->
        <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="add-checklist-form">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addChecklistModalLabel">Add Checklist Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="checklist-name" class="form-label">Item Name</label>
                                <input type="text" name="name" id="checklist-name" class="form-control" required>
                            </div>
                            <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $task->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ $task->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date" class="form-control"
                                    value="{{ $task->due_date }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   



    



    <script>
        let timer;
        let seconds = 0;
        let isRunning = false;

        function formatTime(sec) {
            let hours = Math.floor(sec / 3600);
            let minutes = Math.floor((sec % 3600) / 60);
            let seconds = sec % 60;

            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function updateTimeDisplay() {
            document.getElementById('time-display').innerText = formatTime(seconds);
        }

        document.getElementById('start-btn').addEventListener('click', () => {
            if (!isRunning) {
                isRunning = true;
                timer = setInterval(() => {
                    seconds++;
                    updateTimeDisplay();
                }, 1000);
            }
        });

        document.getElementById('pause-btn').addEventListener('click', () => {
            if (isRunning) {
                isRunning = false;
                clearInterval(timer);
            }
        });

        document.getElementById('reset-btn').addEventListener('click', () => {
            isRunning = false;
            clearInterval(timer);
            seconds = 0;
            updateTimeDisplay();
        });

        updateTimeDisplay();

        function toggleChecklistItem(itemId) {
            const url = '{{ route('checklist-items.update-status', ':id') }}'.replace(':id', itemId);
            const checkbox = document.getElementById(`checklist-item-checkbox-${itemId}`);
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const label = checkbox.closest('.form-check').querySelector('.form-check-label');
                        label.classList.toggle('text-decoration-line-through', checkbox.checked);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // function toggleChecklistItem(itemId) {
        //     const checkbox = document.getElementById(`checklist-item-checkbox-${itemId}`);
        //     const form = document.getElementById(`edit-checklist-form-${itemId}`);
        //     const formData = new FormData(form);
        //     formData.append('completed', checkbox.checked ? '1' : '0');

        //     fetch(form.action, {
        //         method: 'POST',
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //         },
        //         body: formData
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             const itemElement = checkbox.closest('li');
        //             const label = checkbox.nextElementSibling;
        //             label.classList.toggle('text-decoration-line-through', checkbox.checked);
        //         }
        //     })
        //     .catch(error => console.error('Error:', error));
        // }

        function deleteChecklistItem(itemId) {
            const form = document.getElementById(`delete-checklist-form-${itemId}`);
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`checklist-item-${itemId}`).remove();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // AJAX for adding checklist item
        document.getElementById('add-checklist-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('{{ route('checklist-items.store', $task->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data)
                        const checklistItem = document.createElement('li');
                        checklistItem.className =
                            'list-group-item d-flex justify-content-between align-items-center';
                        checklistItem.id = `checklist-item-${data.id}`;
                        checklistItem.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checklist-item-checkbox-${data.id}"
                                onchange="toggleChecklistItem(${data.id})">
                            <label class="form-check-label">${data.name}</label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editChecklistModal-${data.id}"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteChecklistItem(${data.id})"><i class="bi bi-trash"></i></button>
                        </div>
                    `;

                        document.getElementById('checklist-items').appendChild(checklistItem);
                        form.reset();
                        document.querySelector('#addChecklistModal .btn-close').click();
                    } else {
                        const errorElement = document.getElementById('checklist-name-error');
                        errorElement.textContent = data.message;
                        errorElement.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
