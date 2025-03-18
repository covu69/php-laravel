<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // login

    public function adminLogin()
    {
        return view('admin.loginAdmin');
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


            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->route('admin.dashboard')->with('success', "Đăng nhập thành công!");
            } else {
                return redirect()->back()->with('error', "Email hoặc mật khẩu không đúng !");
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Lỗi: " . $e->getMessage());
        }
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        // Xóa session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất thành công.');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function indexUser()
    {
        $users = User::all();
        return view('admin.user.list', compact('users'));
    }

    public function addUser()
    {
        return view('admin.user.add');
    }

    public function savaUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('admin.user.list')->with('success', 'Thêm mới user thành công !');

        } catch (Exception $e) {
            return redirect()->back()->with('error', "Lỗi: " . $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);

            User::where('id', $id)->update($request->only('name', 'email'));

            return redirect()->route('admin.user.list')->with('success', 'Cập nhật thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Lỗi: " . $e->getMessage());
        }
    }
    public function destroyUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.user.list');
    }

    // khóa học

    public function indexCourse()
    {
        $courses = Course::all();
        return view('admin.course.list', compact('courses'));
    }

    public function createCoures()
    {
        return view('admin.course.add');
    }

    public function storeCoures(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'is_free' => 'required|in:0,1', // Bắt buộc chọn Miễn phí hoặc Mất phí
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Nếu là khóa học miễn phí, giá = 0
        $price = $request->is_free == 0 ? 0 : $request->price;

        // Xử lý ảnh
        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('uploads/courses', 'public');
        }

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_free' => $request->is_free,
            'price' => $price,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.course.list')->with('success', 'Khóa học đã được tạo thành công.');
    }


    public function showCourse(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.course.edit', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'is_free' => 'required|in:0,1',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $course = Course::findOrFail($id);

        // Nếu là khóa học miễn phí, đặt giá = 0
        $price = $request->is_free == 0 ? 0 : $request->price;

        // Xử lý ảnh
        if ($request->hasFile('image_url')) {
            // Xóa ảnh cũ nếu có
            if ($course->image_url && file_exists(public_path('storage/' . $course->image_url))) {
                unlink(public_path('storage/' . $course->image_url));
            }
            $imagePath = $request->file('image_url')->store('uploads/courses', 'public');
        } else {
            $imagePath = $course->image_url;
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_free' => $request->is_free,
            'price' => $price,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.course.list')->with('success', 'Khóa học đã được cập nhật thành công.');
    }



    public function destroyCourse($id)
    {
        Course::where('id', $id)->delete();
        return redirect()->route('admin.course.list')->with('success', 'Khóa học đã được xóa.');
    }
}
