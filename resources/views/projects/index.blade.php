@extends('layouts.app')
@section('title')
    Projects
@endsection
@section('content')
    <style>
        /* Fond général de la page */
        .trello-container {
            background-color: #0079bf; /* Bleu Trello */
            padding-top: 30px;
            min-height: 100vh;
        }

        /* Section de la page avec le titre et le bouton */
        .trello-header {
            background-color: white;
            color: #172b4d;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .trello-btn-add {
            background-color: #5aac44; /* Vert Trello */
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Carte de projet */
        .trello-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .trello-card-body {
            padding: 20px;
            color: #172b4d;
        }

        .trello-card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .trello-card-text {
            color: #555;
        }

        /* Boutons du projet */
        .trello-btn {
            background-color: #5aac44; /* Vert Trello */
            color: white;
            border-radius: 5px;
            padding: 8px 12px;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-right: 5px;
        }

        .trello-btn-view {
            background-color: #026aa7; /* Bleu foncé */
        }

        .trello-btn-edit {
            background-color: #ffc107; /* Jaune */
            color: black;
        }

        .trello-btn-delete {
            background-color: #e53935; /* Rouge */
        }

        .trello-btn:hover {
            opacity: 0.9;
        }

        /* Message de succès */
        .alert-success {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Carte d'état de projet */
        .trello-status {
            font-weight: bold;
        }

        .trello-status.deadline-passed {
            color: #e53935; /* Rouge */
            font-weight: bold;
        }
    </style>

    <div class="container trello-container">
        <div class="trello-header">
            <h2>Projects</h2>
            <a href="{{ route('projects.create') }}" class="trello-btn-add">Add Project</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card trello-card">
                        <div class="card-body trello-card-body">
                            <h5 class="trello-card-title">{{ $project->name }}</h5>
                            <p class="trello-card-text">{{ $project->description }}</p>
                            <p class="trello-card-text">
                                <span class="trello-status">
                                    <strong>Status:</strong> 
                                    {{ $project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed') }}<br>
                                    <strong>Deadline:</strong> 
                                    @if($project->end_date && $project->end_date->isFuture())
                                        {{ $project->end_date->diffForHumans() }}
                                    @else
                                        <span class="trello-status deadline-passed">Deadline Passed</span>
                                    @endif
                                </span>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('projects.tasks.index', $project->id) }}" class="trello-btn">
                                    <i class="bi bi-list"></i> Tasks
                                </a>
                                <a href="{{ route('projects.show', $project->id) }}" class="trello-btn trello-btn-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="trello-btn trello-btn-edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="trello-btn trello-btn-delete" onclick="return confirm('Are you sure you want to delete this project?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
