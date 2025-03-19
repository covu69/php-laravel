<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            /* Chiều cao cố định */
            object-fit: cover;
            /* Giữ tỉ lệ ảnh và cắt bớt phần dư */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>

<body>
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Khóa học</a>

            <div class="d-flex">
                @if(Auth::guard('web')->check())
                    <span class="navbar-text text-white me-3">
                        Xin chào, <strong>{{ Auth::guard('web')->user()->name }}</strong>
                    </span>

                    <form id="logout-form" action="{{ route('client.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('client.login') }}" class="btn btn-outline-primary">Đăng nhập</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Danh sách khóa học -->
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách khóa học</h2>
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $course->image_url) }}" class="card-img-top"
                            alt="Hình ảnh khóa học">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                            <p>
                                @if($course->is_free == 0)
                                    <span class="badge bg-success">Miễn phí</span>
                                @else
                                    @auth
                                        @if(Auth::user()->enrolledCourses->contains($course->id))
                                            <span class="badge bg-primary">Đã mua</span>
                                        @else
                                            <span class="badge bg-danger">Mất phí</span>
                                            <strong>{{ number_format($course->price, 0) }} VND</strong>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">Mất phí</span>
                                        <strong>{{ number_format($course->price, 0) }} VND</strong>
                                    @endauth
                                @endif
                            </p>

                            @auth
                                    <a href="{{ route('user.course.show', $course->id) }}" class="btn 
                                {{ Auth::guard('web')->user()->enrolledCourses->contains($course->id) ? 'btn-success' : 'btn-primary' }}">
                                        {{ Auth::guard('web')->user()->enrolledCourses->contains($course->id) ? 'Xem khóa học' : 'Xem chi tiết' }}
                                    </a>
                            @else
                                <a href="{{ route('user.course.show', $course->id) }}" class="btn btn-primary">Xem chi tiết</a>
                            @endauth
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>