@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <style>
        /* Fond global du board Trello-like */
        .custom-dashboard {
            background-color: #0079bf; /* Bleu Trello */
            color: #000; /* Texte noir */
            padding: 20px;
            min-height: 100vh;
        }
        /* Style du titre et des textes */
        .custom-dashboard h2,
        .custom-dashboard p {
            color: #000; /* Texte noir */
        }
        /* Cartes inspirées de Trello */
        .custom-card {
            background-color: #ebecf0; /* Fond clair Trello */
            border: none;
            border-radius: 3px;
            box-shadow: 0 1px 0 rgba(9,30,66,0.25);
            color: #000; /* Texte noir */
        }
        /* Bouton de style Trello (vert) */
        .custom-btn {
            background-color: #5aac44;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #519839;
        }
        /* Style des éléments de liste (cartes de résumé) */
        .custom-list-item {
            background-color: #fff;
            border: none;
            border-radius: 3px;
            margin-bottom: 8px;
            box-shadow: 0 1px 0 rgba(9,30,66,0.25);
            color: #000; /* Texte noir */
        }
        /* Badge de style Trello (bleu foncé) */
        .custom-badge {
            background-color: #0079bf;
            color: #fff;
            border-radius: 3px;
            padding: 2px 4px;
            font-size: 12px;
        }
    </style>
    <div class="container custom-dashboard">
        <h2>Welcome to your Dashboard</h2>
        <p>This is your dashboard where you can manage your tasks, routines, notes, and files.</p>
        
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tasks</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $tasksCount }}</strong> tasks pending.</p>
                        <a href="{{ route('projects.index') }}" class="btn custom-btn mt-auto">View Tasks</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Routines</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $routinesCount }}</strong> routines scheduled today.</p>
                        <a href="{{ route('routines.index') }}" class="btn custom-btn mt-auto">View Routines</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Notes</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $notesCount }}</strong> notes saved.</p>
                        <a href="{{ route('notes.index') }}" class="btn custom-btn mt-auto">View Notes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Files</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $filesCount }}</strong> files.</p>
                        <a href="{{ route('files.index') }}" class="btn custom-btn mt-auto">View Files</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Recent Tasks</h5>
                        <ul class="list-group flex-grow-1">
                            @foreach($recentTasks as $task)
                                <li class="list-group-item custom-list-item d-flex justify-content-between align-items-center">
                                    {{ $task->title }}
                                    <span class="badge custom-badge">{{ $task->status == 'to_do' ? 'To Do' : 'In Progress' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Today's Routines</h5>
                        <ul class="list-group flex-grow-1">
                            @foreach($todayRoutines as $routine)
                                <li class="list-group-item custom-list-item d-flex justify-content-between align-items-center">
                                    {{ $routine->title }}
                                    <span class="badge custom-badge">{{ $routine->frequency }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Recent Notes</h5>
                        <ul class="list-group flex-grow-1">
                            @foreach($recentNotes as $note)
                                <li class="list-group-item custom-list-item d-flex justify-content-between align-items-center">
                                    {{ $note->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card custom-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Upcoming Reminders</h5>
                        <ul class="list-group flex-grow-1">
                            @foreach($upcomingReminders as $reminder)
                                <li class="list-group-item custom-list-item d-flex justify-content-between align-items-center {{ $reminder->date->isToday() ? 'bg-warning' : ($reminder->date->isPast() ? 'bg-danger' : 'bg-success') }}">
                                    {{ $reminder->title }}
                                    <span class="badge custom-badge">{{ $reminder->date->format('M d') }} {{ $reminder->time ? $reminder->time->format('H:i') : '' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
