<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    @if(session('message'))
        <p style="color:green">{{ session('message') }}</p>
    @endif

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required><br><br>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

        <!-- Password -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <!-- Confirm Password -->
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>

        <!-- Role -->
        <label for="role">Register As:</label>
        <select id="role" name="role" required>
            <option value="">-- Select Role --</option>
            <option value="teacher" {{ old('role')=='teacher' ? 'selected' : '' }}>Teacher</option>
            <option value="student" {{ old('role')=='student' ? 'selected' : '' }}>Student</option>
        </select><br><br>

        <!-- Teacher -->
        <div id="teacher-fields" style="display:none;">
            <label for="subject_specialization">Subject Specialization:</label>
            <input type="text" id="subject_specialization" name="subject_specialization" value="{{ old('subject_specialization') }}"><br><br>
        </div>

        <!-- Student -->
        <div id="student-fields" style="display:none;">
            <label for="class_grade">Class/Grade:</label>
            <input type="text" id="class_grade" name="class_grade" value="{{ old('class_grade') }}"><br><br>
        </div>

        <button type="submit">Register</button>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleSelect.addEventListener('change', function() {
            teacherFields.style.display = this.value === 'teacher' ? 'block' : 'none';
            studentFields.style.display = this.value === 'student' ? 'block' : 'none';
        });

        window.addEventListener('DOMContentLoaded', () => {
            if(roleSelect.value === 'teacher') teacherFields.style.display = 'block';
            if(roleSelect.value === 'student') studentFields.style.display = 'block';
        });
    </script>
</body>
</html>
