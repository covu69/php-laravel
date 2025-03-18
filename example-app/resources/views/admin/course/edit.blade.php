@extends('layout.admin')

@section('title', 'Admin Course')

@section('header', 'Course')

@section('content')
    <div class="container">
        <h2 class="mb-4">Cập nhật Khóa học</h2>

        <form action="{{ route('admin.course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" required>{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Loại khóa học</label>
                <select name="is_free" class="form-control" required>
                    <option value="0" {{ $course->is_free == 0 ? 'selected' : '' }}>Miễn phí</option>
                    <option value="1" {{ $course->is_free == 1 ? 'selected' : '' }}>Mất phí</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ $course->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh hiện tại</label>
                <br>
                @if($course->image_url)
                    <img src="{{ asset('storage/' . $course->image_url) }}" width="100">
                @else
                    <span class="text-muted">Chưa có ảnh</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Chọn hình ảnh mới</label>
                <input type="file" name="image_url" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

@endsection
