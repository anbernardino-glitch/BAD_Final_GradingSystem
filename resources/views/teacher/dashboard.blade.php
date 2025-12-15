<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Welcome & Logout -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Teacher: {{ $teacher->user->name ?? $teacher->name }}</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>

    <!-- Add Subject Button -->
    <div class="mb-3 text-end">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">Add Subject</button>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('teacher.subjects.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="Subject Name" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Subjects & Students -->
    @forelse($teacher->subjects as $subject)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ $subject->name }}</h5>
                <form action="{{ route('teacher.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
            <div class="card-body">

                @if($subject->students->isNotEmpty())
                    <form action="{{ route('teacher.submit.grades', $subject->id) }}" method="POST">
                        @csrf

                        <!-- Term selection -->
                        <div class="mb-3">
                            <label for="term-{{ $subject->id }}" class="form-label">Select Term</label>
                            <select name="term" id="term-{{ $subject->id }}" class="form-select" required>
                                <option value="1st Term" @if(old('term')=='1st Term') selected @endif>1st Term</option>
                                <option value="2nd Term" @if(old('term')=='2nd Term') selected @endif>2nd Term</option>
                                <option value="Final Term" @if(old('term')=='Final Term') selected @endif>Final Term</option>
                            </select>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Quizzes</th>
                                    <th>Projects</th>
                                    <th>Exams</th>
                                    <th>Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subject->students as $student)
                                @php
                                    $selectedTerm = old('term', '1st Term');
                                    $grade = $student->grades
                                    ->where('subject_id', $subject->id)
                                    ->where('term', $selectedTerm)
                                    ->first();

                                    $quizzes = $grade ? json_decode($grade->quiz, true) ?? [] : [];
                                    $projects = $grade ? json_decode($grade->project, true) ?? [] : [];
                                    $exams = $grade ? json_decode($grade->exam, true) ?? [] : [];
                                    $submitted = $grade && $grade->status === 'submitted';
                                    $revisionRequested = $grade && $grade->status === 'revision_requested';
                                @endphp
                                <tr data-student-id="{{ $student->id }}">
                                    <td>{{ $student->student_number ?? 'N/A' }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->user->email ?? 'N/A' }}</td>

                                    <!-- Quizzes -->
                                    <td>
                                        <div class="quizzes">
                                            @forelse($quizzes as $q)
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][quiz][]" 
                                                       value="{{ $q }}" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @empty
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][quiz][]" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @endforelse

                                            @if(!$submitted || $revisionRequested)
                                                <button type="button" class="btn btn-sm btn-success add-quiz">+</button>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Projects -->
                                    <td>
                                        <div class="projects">
                                            @forelse($projects as $p)
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][project][]" 
                                                       value="{{ $p }}" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @empty
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][project][]" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @endforelse

                                            @if(!$submitted || $revisionRequested)
                                                <button type="button" class="btn btn-sm btn-success add-project">+</button>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Exams -->
                                    <td>
                                        <div class="exams">
                                            @forelse($exams as $e)
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][exam][]" 
                                                       value="{{ $e }}" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @empty
                                                <input type="number" 
                                                       name="grades[{{ $student->id }}][exam][]" 
                                                       class="form-control form-control-sm mb-1 score-input" 
                                                       min="0" max="100"
                                                       @if($submitted && !$revisionRequested) readonly @endif>
                                            @endforelse

                                            @if(!$submitted || $revisionRequested)
                                                <button type="button" class="btn btn-sm btn-success add-exam">+</button>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Final -->
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm final-grade" 
                                               value="{{ $grade->final ?? 0 }}" 
                                               readonly>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-sm"
                            @if($submitted && !$revisionRequested) disabled style="background-color: grey; border-color: grey;" @endif>
                            Submit Grades For Approval
                        </button>

                    </form>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Quizzes</th>
                                <th>Projects</th>
                                <th>Exams</th>
                                <th>Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No students enrolled yet</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @empty
        <div class="card mb-4">
            <div class="card-header">
                <h5>No subjects assigned</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Quizzes</th>
                            <th>Projects</th>
                            <th>Exams</th>
                            <th>Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No subjects assigned yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforelse

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const computeFinal = row => {
        const avg = selector => {
            const inputs = Array.from(row.querySelectorAll(selector)).map(i => parseFloat(i.value) || 0);
            return inputs.length ? inputs.reduce((a, b) => a + b, 0) / inputs.length : 0;
        };
        const final = avg('.quizzes input') * 0.3 + avg('.projects input') * 0.3 + avg('.exams input') * 0.4;
        row.querySelector('.final-grade').value = final.toFixed(2);
    };

    document.querySelectorAll('tr[data-student-id]').forEach(row => {
        row.addEventListener('input', () => computeFinal(row));
        computeFinal(row);

        ['quiz', 'project', 'exam'].forEach(type => {
            const btn = row.querySelector(`.add-${type}`);
            if (!btn) return;
            btn.addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'number';
                input.name = `grades[${row.dataset.studentId}][${type}][]`;
                input.min = 0;
                input.max = 100;
                input.className = 'form-control form-control-sm mb-1 score-input';
                input.addEventListener('input', () => computeFinal(row));
                row.querySelector(`.${type}s`).insertBefore(input, btn);
            });
        });
    });

});
</script>


</body>
</html>
