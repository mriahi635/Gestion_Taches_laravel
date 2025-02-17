@extends('layouts.app')
@section('title')
    Create Task
@endsection
@section('content')
    <style>
        /* Fond général de la page */
        .trello-container {
            background-color: #0079bf; /* Bleu Trello */
            padding-top: 30px;
            min-height: 100vh;
        }

        /* Titre de la page */
        .trello-header {
            background-color: white;
            color: #172b4d;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* Formulaire */
        .trello-form {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-size: 18px;
            color: #333;
        }

        .form-control, .form-select {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-control:focus, .form-select:focus {
            border-color: #026aa7; /* Bleu Trello */
            box-shadow: 0 0 5px rgba(2, 106, 167, 0.5);
        }

        .text-danger {
            font-size: 14px;
            color: #d9534f; /* Rouge Trello */
        }

        .trello-btn-submit {
            background-color: #5aac44; /* Vert Trello */
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 8px;
            border: none;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .trello-btn-submit:hover {
            background-color: #4c9f3d;
        }
    </style>

    <div class="container trello-container">
        <h2 class="trello-header text-center">Create Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST" class="trello-form">
            @csrf
            <div class="mb-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control">
                @error('due_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" id="priority" class="form-select" required>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="trello-btn-submit">
                Create Task
            </button>
        </form>
    </div>
@endsection
