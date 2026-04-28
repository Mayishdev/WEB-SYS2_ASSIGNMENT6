@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 1.25rem 1.25rem 0 0;">
                    <h3 class="mb-0">{{ $student->name }}</h3>
                    <small>Student Profile & QR Code</small>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($student->picture_path)
                                <img src="{{ Storage::url($student->picture_path) }}" alt="Student Picture" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">Student Details</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Student ID:</strong> {{ $student->student_id }}</li>
                                <li class="list-group-item"><strong>Name:</strong> {{ $student->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $student->email }}</li>
                                <li class="list-group-item"><strong>Course:</strong> {{ $student->course }}</li>
                                <li class="list-group-item"><strong>Phone:</strong> {{ $student->phone ?: 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
    <h5>QR Code</h5>
    <div style="max-width: 250px; margin: 0 auto;">
        {!! $qr !!}
    </div>
    <p class="text-muted mt-2">Scan this QR code to access student information.</p>
</div>
                    <div class="text-center mt-4">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary ms-2">Edit Student</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection