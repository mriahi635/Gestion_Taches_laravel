@extends('layouts.app')

@section('title')
    {{ $project->name }} - Tasks
@endsection

@section('content')
    <style>
        body {
            background-color: #0079bf; /* Bleu de fond du site */
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .kanban-column {
            background-color: #ebecf0;
            padding: 10px;
            border-radius: 8px;
            margin-right: 15px;
            box-shadow: 0 1px 0 rgba(9,30,66,0.25);
            height: 100%;
            transition: all 0.3s ease;
        }
        .kanban-column h4 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            padding: 4px 8px;
            color: #172b4d;
        }
        .kanban-list {
            min-height: 100px;
            background-color: #f4f5f7;
            padding: 8px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .kanban-item {
            background-color: #fff;
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 8px;
            box-shadow: 0 1px 0 rgba(9,30,66,0.25);
            cursor: grab;
            transition: all 0.2s ease;
        }
        .kanban-item:hover {
            background-color: #f1f2f4;
            transform: scale(1.03);
        }
        .kanban-item.invisible {
            opacity: 0.4;
        }
        .btn-add {
            background-color: #0079bf; /* Bleu pour le bouton Ajouter */
            border: none;
            color: #fff;
            border-radius: 3px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-add:hover {
            background-color: #005f8a; /* Un bleu plus foncé au survol */
        }
        .modal-content {
            border-radius: 3px;
        }
        .modal-header {
            background-color: #0079bf;
            color: #fff;
            border-bottom: none;
            border-radius: 3px 3px 0 0;
        }
        .btn-primary {
            background-color: #5aac44;
            border: none;
            border-radius: 3px;
            padding: 6px 12px;
            font-size: 14px;
        }
        .btn-primary:hover {
            background-color: #519839;
        }
        .btn-secondary {
            background-color: #b6bbbf;
            border: none;
            border-radius: 3px;
            padding: 6px 12px;
            font-size: 14px;
        }
        .btn-secondary:hover {
            background-color: #a5acb1;
        }
        .kanban-column:active {
            background-color: #c8d6e5;
        }
    </style>

    <div class="container">
        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded" style="background-color: #ebecf0;">
            <h2 class="text-center" style="color: #333;">{{ $project->name }} - Tasks</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="background-color: #5aac44; color: #fff; padding: 10px; border-radius: 3px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Colonne "To Do" -->
            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between align-items-center px-2 pb-1">
                        <h4>To Do</h4>
                        <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#createTaskModal" data-status="to_do">+</button>
                    </div>
                    <div class="kanban-list" id="to_do">
                        @foreach ($tasks['to_do'] ?? [] as $task)
                            <div class="card kanban-item" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body p-2">
                                    <h5 class="card-title" style="font-size: 14px;">
                                        {{ $task->title }} 
                                        <span class="badge {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}" style="font-size: 10px;">{{ ucfirst($task->priority) }}</span>
                                    </h5>
                                    <p class="card-text" style="font-size: 12px;">{{ $task->description }}</p>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary btn-sm" style="font-size: 12px;"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne "In Progress" -->
            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between align-items-center px-2 pb-1">
                        <h4>In Progress</h4>
                        <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#createTaskModal" data-status="in_progress">+</button>
                    </div>
                    <div class="kanban-list" id="in_progress">
                        @foreach ($tasks['in_progress'] ?? [] as $task)
                            <div class="card kanban-item" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body p-2">
                                    <h5 class="card-title" style="font-size: 14px;">{{ $task->title }}</h5>
                                    <p class="card-text" style="font-size: 12px;">{{ $task->description }}</p>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-warning btn-sm" style="font-size: 12px;"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne "Completed" -->
            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between align-items-center px-2 pb-1">
                        <h4>Completed</h4>
                        <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#createTaskModal" data-status="completed">+</button>
                    </div>
                    <div class="kanban-list" id="completed">
                        @foreach ($tasks['completed'] ?? [] as $task)
                            <div class="card kanban-item" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body p-2">
                                    <h5 class="card-title" style="font-size: 14px;">{{ $task->title }}</h5>
                                    <p class="card-text" style="font-size: 12px;">{{ $task->description }}</p>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-success btn-sm" style="font-size: 12px;"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de création de tâche -->
        <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields for task creation -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kanbanItems = document.querySelectorAll('.kanban-item');
            const kanbanLists = document.querySelectorAll('.kanban-list');
            const createTaskModal = document.getElementById('createTaskModal');
            const taskStatusInput = document.getElementById('task_status');

            createTaskModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var status = button.getAttribute('data-status');
                taskStatusInput.value = status;
            });

            kanbanItems.forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragend', handleDragEnd);
            });

            kanbanLists.forEach(list => {
                list.addEventListener('dragover', handleDragOver);
                list.addEventListener('drop', handleDrop);
            });

            function handleDragStart(e) {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                setTimeout(() => {
                    e.target.classList.add('invisible');
                }, 0);
            }

            function handleDragEnd(e) {
                e.target.classList.remove('invisible');
            }

            function handleDragOver(e) {
                e.preventDefault();
            }

            function handleDrop(e) {
                e.preventDefault();
                const id = e.dataTransfer.getData('text');
                const draggableElement = document.querySelector(`.kanban-item[data-id='${id}']`);
                const dropzone = e.target.closest('.kanban-list');
                dropzone.appendChild(draggableElement);
                const status = dropzone.id;
                updateTaskStatus(id, status);
            }

            function updateTaskStatus(id, status) {
                fetch(`/tasks/${id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status })
                }).then(response => {
                    if (!response.ok) throw new Error('Failed to update task status');
                    return response.json();
                }).then(data => {
                    console.log('Task status updated:', data);
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>
@endsection
