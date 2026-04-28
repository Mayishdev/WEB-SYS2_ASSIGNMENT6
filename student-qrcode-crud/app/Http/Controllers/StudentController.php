<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Use the Facade instead

class StudentController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('student_id', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('course', 'like', '%' . $search . '%');
        }

        $students = $query->get()->map(function ($student) {
            // Generate temporary QR for the table view
            $student->qr = QrCode::size(50)->generate(route('students.show', $student->id));
            return $student;
        });

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    /**
     * Store new student data and save QR as PNG.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students',
            'name' => 'required',
            'email' => 'required|email',
            'course' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['student_id', 'name', 'email', 'course']);

        // Handle picture upload
        if ($request->hasFile('picture')) {
            $data['picture_path'] = $request->file('picture')->store('pictures', 'public');
        }

        $student = Student::create($data);

        // Save QR Code using the proper Facade method
        $this->generateAndSaveQr($student);

        return redirect()->route('students.index')->with('success', 'Student created.');
    }

    public function show(Student $student)
    {
        $qr = QrCode::size(250)->generate(json_encode([
            'id' => $student->student_id,
            'name' => $student->name,
            'course' => $student->course,
        ]));

        return view('students.show', compact('student', 'qr'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'name' => 'required',
            'email' => 'required|email',
            'course' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['student_id', 'name', 'email', 'course']);

        if ($request->hasFile('picture')) {
            if ($student->picture_path) { Storage::disk('public')->delete($student->picture_path); }
            $data['picture_path'] = $request->file('picture')->store('pictures', 'public');
        }

        $student->update($data);
        $this->generateAndSaveQr($student);

        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        if ($student->picture_path) { Storage::disk('public')->delete($student->picture_path); }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    /**
     * Helper Method to save QR as PNG using GD
     */
    private function generateAndSaveQr($student)
    {
       $folderPath = storage_path('app/public/qrcodes');
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $qrData = json_encode([
        'id' => $student->student_id,
        'name' => $student->name,
        'course' => $student->course
    ]);

    try {
    
        $fileName = 'student_' . $student->id . '.png';
        $fullPath = $folderPath . '/' . $fileName;

        QrCode::format('png')
            ->size(300)
            ->margin(1)
            ->generate($qrData, $fullPath);
            
        $student->update(['qrcode_path' => 'qrcodes/' . $fileName]);

    } catch (\Exception $e) {
        
        $fileName = 'student_' . $student->id . '.svg';
        $fullPath = $folderPath . '/' . $fileName;

        QrCode::size(300)
            ->margin(1)
            ->generate($qrData, $fullPath);

        $student->update(['qrcode_path' => 'qrcodes/' . $fileName]);
    }
    }}
