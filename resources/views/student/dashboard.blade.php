@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Student Dashboard</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Welcome, {{ Auth::user()->name }}</h4>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="card p-4 shadow-sm">
        <h5>Available Tests</h5>
        <ul class="list-group">
            @forelse($tests as $test)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $test->title }}</strong> <br>
                        <small>Subject: {{ $test->subject->name ?? 'N/A' }}</small>
                    </div>
                    <a href="{{ route('student.tests.show', $test->id) }}" class="btn btn-primary btn-sm">
                        Open Test
                    </a>
                </li>
            @empty
                <li class="list-group-item">No tests available yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
