<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>{{ $course->title }}</h2>
        <img src="{{ asset('storage/' . $course->image_url) }}" class="img-fluid w-50 mb-3" alt="Hình ảnh khóa học">
        <p>{{ $course->description }}</p>

        @if($course->is_free == 0 || session('success'))
            <h4>Bài học</h4>
            <ul>
                @foreach ($course->lessons as $lesson)
                    <li>
                        <strong>{{ $lesson->title }}</strong>
                        <video controls width="100%">
                            <source src="{{ asset('storage/' . $lesson->video_url) }}" type="video/mp4">
                        </video>
                    </li>
                @endforeach
            </ul>
            @endif
    </div>
</body>

</html>