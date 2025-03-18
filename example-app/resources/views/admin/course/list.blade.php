@extends('layout.admin')

@section('title', 'Admin Course')

@section('header', 'Course')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Danh sách khóa học</h2>

        <!-- Thông báo Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.course.add') }}" class="btn btn-primary mb-3">Thêm mới</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>
                            @if($course->image_url)
                                <img src="{{ asset('storage/' . $course->image_url) }}" width="80">
                            @else
                                <span class="text-muted">Chưa có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $course->title }}</td>
                        <td>{{ Str::limit($course->description, 50) }}</td>
                        <td>
                            @if($course->is_free == 0)
                                <span class="badge bg-success">Miễn phí</span>
                            @else
                                <span class="badge bg-danger">Mất phí</span>
                            @endif
                        </td>
                        <td>{{ number_format($course->price, 0) }} VND</td>
                        <td>
                            <a href="{{ route('admin.course.edit', $course->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.course.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function () {
            let successMessage = document.getElementById("successMessage");
            if (successMessage) {
                successMessage.style.display = "none";
            }
        }, 3000);
    </script>

@endsection
