@extends('layouts.app')

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

        h2 {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 30px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .card-text {
            color: #555;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .d-flex {
            margin-top: 10px;
        }

        .btn {
            border-radius: 50%;
            padding: 10px;
            width: 40px;
            height: 40px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .btn-warning {
            background-color: #f9a825; /* Trello-like yellow */
            border-color: #f9a825;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #c17900;
        }

        .btn-danger {
            background-color: #d32f2f; /* Trello red */
            border-color: #d32f2f;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #9a0007;
        }

        .card-footer {
            padding: 0;
            background-color: #f8f9fa;
            border-top: 1px solid #e1e1e1;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .col-md-4 {
            flex: 0 0 31.33%;
        }

        /* Empty state */
        .text-center {
            font-size: 1.2rem;
            color: #777;
        }
    </style>

    <div class="container">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Daily Routines</h2>

        <div class="row">
            @forelse($dailyRoutines as $routine)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $routine->title }}</h5>
                            <p class="card-text">{{ $routine->description }}</p>
                            <p class="card-text"><strong>Days:</strong> {{ implode(', ', json_decode($routine->days, true) ?? []) }}</p>
                            <p class="card-text"><strong>Time:</strong> {{ $routine->start_time }} - {{ $routine->end_time }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('routines.edit', $routine->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('routines.destroy', $routine->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this routine?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No daily routines found.</p>
            @endforelse
        </div>
    </div>
@endsection
