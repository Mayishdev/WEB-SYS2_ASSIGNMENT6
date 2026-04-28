

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Portal</title>
</head>
<style>
   <style>
    body { background-color: #f3f4f6; }

    /* Custom Row Hover */
    .student-row { transition: all 0.2s ease; border-bottom: 1px solid #f0f0f0; }
    .student-row:hover { background-color: #fbfbfc; transform: scale(1.002); }

    /* Avatar UI */
    .avatar-box {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
    }

    /* Status Indicator */
    .status-dot {
        width: 8px; height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    /* QR Code Container */
    .qr-preview svg {
        width: 40px !important; height: 40px !important;
        padding: 3px; background: white; border-radius: 6px;
    }

    /* Buttons Style */
    .action-btn {
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        transition: 0.2s;
    }
    
    /* Clean Input */
    .form-control:focus { box-shadow: none; }
    
    /* Typography */
    .tracking-tight { letter-spacing: -0.025em; }
</style>
</style>
<body>
@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container py-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="row align-items-center mb-5">
        <div class="col-md-7">
            <h1 class="fw-bold text-dark tracking-tight">Student Directory</h1>
            <p class="text-muted border-start border-3 border-primary ps-3">Centralized management for student digital identification and records.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg rounded-3 shadow-sm px-4">
                <i class="fas fa-user-plus me-2"></i>Enroll Student
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1.25rem;">
        <div class="card-header bg-white border-0 p-4">
            <form action="{{ route('students.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group bg-light rounded-3 p-1">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-transparent border-0" placeholder="Search by name, ID, email, course, phone..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-dark rounded-3 px-3">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold">STUDENT PROFILE</th>
                        <th class="py-3 text-muted small fw-bold text-center">QR IDENTITY</th>
                        <th class="py-3 text-muted small fw-bold">STUDENT ID</th>
                        <th class="py-3 text-muted small fw-bold text-end pe-4">MANAGEMENT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="student-row">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($student->picture_path)
                                    <img src="{{ Storage::url($student->picture_path) }}" alt="Picture" class="me-3 rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                                @else
                                    <div class="avatar-box me-3">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        {{ $student->name }}
                                        <span class="status-dot ms-2"></span>
                                    </div>
                                    <small class="text-muted">{{ $student->course }} • {{ $student->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($student->qrcode_path)
                                <img src="{{ Storage::url($student->qrcode_path) }}" alt="QR Code" class="qr-preview shadow-sm" style="width: 40px; height: 40px;">
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-medium px-3 py-2 rounded-pill">
                                {{ $student->student_id }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline-info btn-sm rounded-2 action-btn" title="View QR">
                                    <i class="fas fa-qrcode me-1"></i> View QR
                                </a>

                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-warning btn-sm rounded-2 action-btn" title="Edit">
                                    <i class="fas fa-pen-to-square me-1"></i> Edit
                                </a>

                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive student data?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-2 action-btn">
                                        <i class="fas fa-trash-can me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
</body>
</html>
