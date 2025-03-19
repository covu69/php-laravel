<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function loginClient(){
        return view('client.login');
    }

    public function checkLogin(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'Email không được để trống!',
                'email.email' => 'Email không hợp lệ!',
                'password.required' => 'Mật khẩu không được để trống!',
            ]);

            $credentials = $request->only('email', 'password');


            if (Auth::guard('web')->attempt($credentials)) {
                session(['user_session' => Auth::guard('web')->user()->id]);
                return redirect()->route('user.course.index')->with('success', "Đăng nhập thành công!");
            } else {
                return redirect()->back()->with('error', "Email hoặc mật khẩu không đúng !");
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Lỗi: " . $e->getMessage());
        }
    }
    public function clientLogout(Request $request)
    {
        Auth::guard('web')->logout();

        // Xóa session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')->with('success', 'Bạn đã đăng xuất thành công.');
    }

    // Danh sách khóa học
    public function index()
    {
        // dd(session()->all());
        $courses = Course::all();
        return view('client.course.index', compact('courses'));
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
                return view('client.course.checkout', compact('course'));
            }
        }

        return view('client.course.show', compact('course'));
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
