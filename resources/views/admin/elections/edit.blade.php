<!DOCTYPE html>
<html>
<head>
    <title>Edit Election</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-3">
        <h2>Edit Election</h2>
        <a href="/admin/elections" class="btn btn-secondary">← Back</a>
    </div>

    <!-- Error messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">

        <form action="{{ route('elections.update', $election->id) }}" method="POST">
            @csrf

            <!-- Election Title -->
            <div class="mb-3">
                <label class="form-label">Election Title</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $election->title) }}"
                       required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description"
                          class="form-control"
                          rows="3">{{ old('description', $election->description) }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date"
                       name="start_date"
                       class="form-control"
                       value="{{ old('start_date', $election->start_date) }}"
                       required>
            </div>

            <!-- End Date -->
            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date"
                       name="end_date"
                       class="form-control"
                       value="{{ old('end_date', $election->end_date) }}"
                       required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Update Election
            </button>

        </form>

    </div>

</div>

</body>
</html>
