<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;

class CheckEnrollment
{
    public function handle(Request $request, Closure $next)
    {
  
        $courseId = $request->route('id');
        $course = Course::findOrFail($courseId);

        // Nếu khóa học miễn phí, cho phép truy cập ngay
        if ($course->is_free == 0) {
            return $next($request);
        }

        // Kiểm tra xem user đã mua khóa học chưa
        $enrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->exists();

        if (!$enrolled) {
            return redirect()->route('user.course.show', $courseId)
                ->with('error', 'Bạn cần mua khóa học để xem nội dung.');
        }

        return $next($request);
    }
}
