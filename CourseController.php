<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = DB::table('courses')->get();

        return view('courses', compact('courses'));
    }

    // Add course
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code',
            'course_name' => 'required',
            'credit_hours' => 'required|integer',
            'semester' => 'required'
        ]);

        DB::table('courses')->insert([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
            'credit_hours' => $request->credit_hours,
            'semester' => $request->semester,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course added successfully!');
    }

    // Edit course
    public function edit($id)
    {
        $course = DB::table('courses')->find($id);

        return view('courses', [
            'courses' => DB::table('courses')->get(),
            'editCourse' => $course
        ]);
    }

    // Update course
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code' => [
                'required',
                Rule::unique('courses')->ignore($id)
            ],
            'course_name' => 'required',
            'credit_hours' => 'required|integer',
            'semester' => 'required'
        ]);

        DB::table('courses')->where('id', $id)->update([
            'course_code' => $request->course_code,
            'course_name' => $request->course_name,
            'credit_hours' => $request->credit_hours,
            'semester' => $request->semester,
            'updated_at' => now()
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully!');
    }

    // Delete course
    public function destroy($id)
    {
        DB::table('courses')->where('id', $id)->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}
