@extends('layouts.app')
@section('title')
    {{ $project->name }} - Project Details
@endsection
@section('content')
    <style>
        /* Fond général de la page */
        .trello-container {
            background-color: #0079bf; /* Bleu Trello */
            padding-top: 30px;
            min-height: 100vh;
        }

        /* Section titre */
        .trello-header {
            background-color: white;
            color: #172b4d;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .trello-card-text {
            color: #555;
        }

        /* Progression du projet */
        .trello-progress {
            height: 20px;
            background-color: #e9ecef;
        }

        .trello-progress-bar {
            background-color: #5aac44; /* Vert Trello */
        }

        .trello-btn-back {
            background-color: #026aa7; /* Bleu foncé Trello */
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        /* Carte des membres de l'équipe */
        .trello-member-card {
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .trello-member-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .trello-member-email {
            font-size: 14px;
            color: #555;
        }

        /* Bouton Ajouter un membre */
        .trello-btn-add {
            background-color: #5aac44; /* Vert Trello */
            color: white;
            border-radius: 8px;
            font-size: 18px;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Modal pour ajouter un membre */
        .modal-content {
            border-radius: 8px;
        }

        .modal-footer .btn {
            border-radius: 8px;
        }
    </style>

    <div class="container trello-container">
        <h2 class="trello-header text-center">{{ $project->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success" style="background-color: #28a745; color: white; padding: 12px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-7">
                <div class="card trello-card mb-4">
                    <div class="card-body trello-card-body">
                        <h5 class="trello-card-title">{{ $project->name }}</h5>
                        <p class="trello-card-text">{{ $project->description }}</p>
                        <p class="trello-card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}</p>
                        <p class="trello-card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') }}</p>
                        <p class="trello-card-text"><strong>Status:</strong> 
                            {{ $project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed') }}
                        </p>
                        <p class="trello-card-text"><strong>Budget:</strong> ${{ $project->budget }}</p>

                        <h5 class="mt-4" style="color: #333; font-size: 20px;">Project Progress</h5>
                        @php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'completed')->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="trello-progress mb-4">
                            <div class="progress-bar trello-progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ round($progress) }}%
                            </div>
                        </div>

                        <a href="{{ route('projects.index') }}" class="trello-btn-back">
                            Back to Projects
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card trello-card mb-4">
                    <div class="card-body trello-card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title" style="font-size: 22px; color: #333;">Team Members</h5>
                            <button type="button" class="trello-btn-add" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        </div>

                        <div class="row">
                            @foreach ($teamMembers as $user)
                                <div class="col-12 mb-3">
                                    <div class="card trello-member-card">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <p class="trello-member-name">{{ $user->name }}</p>
                                                    <p class="trello-member-email">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.addMember')}}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select class="form-select" name="user_id" style="border-radius: 8px; height: 50px; font-size: 16px;">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 16px; padding: 12px 25px;">Close</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 8px; font-size: 18px; padding: 12px 30px;">Add Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
