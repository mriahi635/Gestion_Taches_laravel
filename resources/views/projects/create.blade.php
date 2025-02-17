@extends('layouts.app')
@section('title')
    Create Project
@endsection
@section('content')
    <style>
        /* Fond général du site - Bleu Trello */
        .trello-container {
            background-color: #0079bf; /* Bleu Trello */
            padding: 30px;
            min-height: 100vh;
            color: #172b4d; /* Texte sombre pour le contraste */
        }

        /* Titre principal */
        .trello-header {
            background-color: #026aa7; /* Bleu foncé */
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(9, 30, 66, 0.25);
            margin-bottom: 20px;
            text-align: center;
        }

        /* Carte de formulaire */
        .trello-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(9, 30, 66, 0.25);
            padding: 20px;
            color: #172b4d;
        }

        /* Champs du formulaire */
        .trello-form-label {
            font-size: 16px;
            color: #172b4d;
        }

        .trello-form-control, .trello-form-select {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: inset 0 1px 3px rgba(9, 30, 66, 0.15);
            width: 100%;
            margin-bottom: 10px;
            background-color: #f4f5f7;
        }

        /* Bouton - Style Trello */
        .trello-btn {
            background-color: #5aac44;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .trello-btn:hover {
            background-color: #519839;
        }

        /* Erreurs de validation */
        .text-danger {
            font-size: 12px;
            color: red;
        }
    </style>

    <div class="container trello-container">
        <h2 class="trello-header">Create Project</h2>
        <div class="card trello-card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="trello-form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control trello-form-control" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="trello-form-label">Description</label>
                        <textarea name="description" id="description" class="form-control trello-form-control"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="trello-form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control trello-form-control">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="trello-form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control trello-form-control">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="trello-form-label">Status</label>
                        <select name="status" id="status" class="form-select trello-form-control" required>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="trello-form-label">Budget</label>
                        <input type="number" name="budget" id="budget" class="form-control trello-form-control" step="0.01">
                        @error('budget')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="trello-btn">
                        Create Project
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
