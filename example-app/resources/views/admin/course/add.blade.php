@extends('layout.admin')

@section('title', 'Thêm Khóa Học')

@section('header', 'Thêm Khóa Học')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Thêm Khóa học</h2>

        <form action="{{ route('admin.course.save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Loại khóa học</label>
                <select name="is_free" class="form-control" required>
                    <option value="0">Miễn phí</option>
                    <option value="1">Mất phí</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" required value="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="image_url" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Thêm khóa học</button>
        </form>
    </div>
@endsection
