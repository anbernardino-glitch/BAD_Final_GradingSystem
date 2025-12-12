@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2>Department Dashboard</h2>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse($submittedGrades as $subjectId => $grades)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $grades->first()->subject->name }}</strong> 
                    - Teacher: {{ $grades->first()->subject->teacher->name ?? 'N/A' }}
                </div>
                <div>
                    <!-- Export/Report Button -->
                    <a href="{{ route('department.report', $subjectId) }}" class="btn btn-info btn-sm">
                        Generate Report
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Quiz</th>
                            <th>Project</th>
                            <th>Exam</th>
                            <th>Final</th>
                            <th>Status / Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->student->name }}</td>
                                <td>{{ implode(', ', json_decode($grade->quiz) ?? []) }}</td>
                                <td>{{ implode(', ', json_decode($grade->project) ?? []) }}</td>
                                <td>{{ implode(', ', json_decode($grade->exam) ?? []) }}</td>
                                <td>{{ $grade->final }}</td>
                                <td>
                                    @if($grade->status == 'submitted')
                                        <!-- Approve -->
                                        <form action="{{ route('department.approve', $grade->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <!-- Request Revision -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#revisionModal{{ $grade->id }}">
                                            Request Revision
                                        </button>

                                        <!-- Revision Modal -->
                                        <div class="modal fade" id="revisionModal{{ $grade->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('department.requestRevision', $grade->id) }}" method="POST" class="modal-content">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Request Grade Revision</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea name="justification" class="form-control" placeholder="Enter reason for revision" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-warning">Send Request</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($grade->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($grade->status == 'revision_requested')
                                        <span class="badge bg-warning">Revision Requested</span>
                                    @elseif($grade->status == 'locked')
                                        <span class="badge bg-secondary">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p>No grades submitted yet.</p>
    @endforelse

    <!-- Logout -->
    <div class="d-flex justify-content-end">
        <form action="{{ route('department.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
