<!DOCTYPE html>
<html>
<head>
    <title>Course Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f6fc;
            font-family: Arial;
            margin: 0;
        }

        .topbar {
            background: #142d56;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            background: #0876ed;
            padding: 10px 15px;
            font-size: 23px;
            border-radius: 7px;
            margin-right: 12px;
        }

        .sidebar {
            background: #142d56;
            color: white;
            width: 245px;
            position: fixed;
            top: 75px;
            bottom: 0;
            padding: 20px 10px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 16px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #0876ed;
        }

        .main {
            margin-left: 245px;
            padding: 35px;
        }

        .heading {
            color: #142d56;
            margin-bottom: 25px;
        }

        .card {
            border: none;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 15px #00000010;
        }

        .card-header {
            background: #e7efff;
            padding: 17px;
            font-weight: bold;
            font-size: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .form-control {
            height: 45px;
        }

        .table th {
            background: #edf1f8;
        }

        .table td, .table th {
            padding: 15px;
            vertical-align: middle;
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 65px;
            }

            .sidebar a {
                font-size: 12px;
                padding: 10px 5px;
            }

            .main {
                margin-left: 65px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<!-- Top Navigation -->

<div class="topbar">

    <div>
        <span class="logo">IT</span>
        <strong style="font-size:25px">IT Student Portal</strong>
    </div>

    <div>
        Welcome, {{ auth()->user()->name ?? 'Abbas' }}
        &nbsp;&nbsp; | &nbsp;&nbsp;

        <form action="{{ route('logout') }}" method="POST"
              style="display:inline">
            @csrf
            <button class="btn btn-primary">Logout</button>
        </form>
    </div>

</div>


<!-- Sidebar -->

<div class="sidebar">

    <a href="{{ url('/dashboard') }}">🏠 Dashboard</a>

    <a href="{{ route('courses.index') }}" class="active">
        📖 Courses
    </a>

    <a href="{{ url('/about') }}">ⓘ About</a>

    <hr>

    <h6>🎓 Kabul University</h6>
    <small>CS Faculty</small>

</div>


<!-- Main Content -->

<div class="main">

    <div class="heading">
        <h1>🎓 Course Management</h1>
        <p>View, add, update and delete your IT courses.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif


    <!-- Add New Course -->

    <div class="card">

        <div class="card-header">
            Add New Course
        </div>

        <div class="card-body">

            <form action="{{ route('courses.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-2">
                        <label>Course Code</label>
                        <input type="text" name="course_code"
                               class="form-control"
                               placeholder="e.g. PY101" required>
                    </div>

                    <div class="col-md-3">
                        <label>Course Name</label>
                        <input type="text" name="course_name"
                               class="form-control"
                               placeholder="e.g. Python Programming" required>
                    </div>

                    <div class="col-md-2">
                        <label>Credit Hours</label>
                        <select name="credit_hours" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option selected>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Semester</label>
                        <select name="semester" class="form-control">
                            <option>Spring 2026</option>
                            <option selected>Fall 2026</option>
                            <option>Spring 2027</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            + Add Course
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- Your Courses -->

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <span>📖 Your Courses</span>

            <span class="badge bg-primary">
                {{ $courses->count() }} Courses
            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($courses as $course)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $course->course_code }}</td>

                            <td>{{ $course->course_name }}</td>

                            <td>{{ $course->credit_hours }}</td>

                            <td>{{ $course->semester }}</td>

                            <td>

                                <a href="{{ route('courses.edit', $course->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('courses.destroy', $course->id) }}"
                                      method="POST" style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this course?')">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No courses found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>
