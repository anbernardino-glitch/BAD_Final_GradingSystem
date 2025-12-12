<table>
<tr>
<th>Student</th><th>Subject</th><th>Final</th><th>Submitted</th><th>Approved</th><th>Locked</th><th>Actions</th>
</tr>
@foreach($grades as $grade)
<tr>
<td>{{ $grade->student->name }}</td>
<td>{{ $grade->subject->name }}</td>
<td>{{ $grade->final_grade }}</td>
<td>{{ $grade->submitted ? 'Yes':'No' }}</td>
<td>{{ $grade->approved ? 'Yes':'No' }}</td>
<td>{{ $grade->locked ? 'Yes':'No' }}</td>
<td>
<form method="POST" action="{{ route('grades.submit',$grade) }}">@csrf<button>Submit</button></form>
<form method="POST" action="{{ route('grades.approve',$grade) }}">@csrf<button>Approve</button></form>
<form method="POST" action="{{ route('grades.lock',$grade) }}">@csrf<button>Lock</button></form>
</td>
</tr>
@endforeach
</table>
