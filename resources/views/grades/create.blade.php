<form method="POST" action="{{ route('grades.store') }}">
@csrf
<select name="student_id">
@foreach($students as $s)
<option value="{{ $s->id }}">{{ $s->name }}</option>
@endforeach
</select>

<select name="subject_id">
@foreach($subjects as $sub)
<option value="{{ $sub->id }}">{{ $sub->name }}</option>
@endforeach
</select>

<input type="text" name="components[quiz]" placeholder="Quiz Score">
<input type="text" name="components[project]" placeholder="Project Score">
<input type="text" name="components[exam]" placeholder="Exam Score">

<button type="submit">Save</button>
</form>
