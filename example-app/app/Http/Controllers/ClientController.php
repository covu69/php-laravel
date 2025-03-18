<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Danh sách khóa học
    public function index()
    {
        $courses = Course::all();
        return view('user.courses.index', compact('courses'));
    }

    // Xem chi tiết khóa học
    public function show($id)
    {
        $course = Course::findOrFail($id);

        // Kiểm tra nếu là khóa học mất phí và người dùng chưa đăng ký
        if ($course->is_free == 1) {
            $enrolled = Enrollment::where('user_id', Auth::guard('web')->id())
                ->where('course_id', $course->id)
                ->exists();
            if (!$enrolled) {
                return view('user.courses.checkout', compact('course'));
            }
        }

        return view('user.courses.show', compact('course'));
    }

    // Xử lý thanh toán (chỉ demo)
    public function checkout(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Kiểm tra nếu khóa học đã được thanh toán
        $enrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();
        if ($enrolled) {
            return redirect()->route('user.course.show', $id)
                ->with('success', 'Bạn đã mua khóa học này!');
        }

        // Thực hiện lưu vào bảng `enrollments` (giả sử đã thanh toán thành công)
        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
        ]);

        return redirect()->route('user.course.show', $id)
            ->with('success', 'Thanh toán thành công! Bạn có thể học ngay.');
    }
}
