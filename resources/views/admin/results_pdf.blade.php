<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>
    <style>
        body { font-family: Arial; }
        table { width:100%; border-collapse: collapse; }
        th,td { border:1px solid #000; padding:8px; text-align:center; }
        th { background:#eee; }
    </style>
</head>
<body>

<h2>{{ $election->title }}</h2>

@if($isTie)
    <h3>Result: TIE</h3>
    <p>Winners:</p>
    <ul>
        @foreach($winners as $w)
            <li>{{ $w->name }} ({{ $w->votes->count() }} votes)</li>
        @endforeach
    </ul>
@else
    <h3>Winner: {{ $winners->first()->name }}</h3>
@endif

<table>
<tr>
    <th>Candidate</th>
    <th>Votes</th>
</tr>
@foreach($election->candidates as $candidate)
<tr>
    <td>{{ $candidate->name }}</td>
    <td>{{ $candidate->votes->count() }}</td>
</tr>
@endforeach

</table>

</body>
</html>
