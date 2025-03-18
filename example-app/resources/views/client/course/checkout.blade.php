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
        <h2>Thanh toán khóa học</h2>
        <p><strong>Khóa học:</strong> {{ $course->title }}</p>
        <p><strong>Giá:</strong> {{ number_format($course->price, 0) }} VND</p>

        <form action="{{ route('user.course.checkout', $course->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
        </form>
    </div>
</body>

</html>