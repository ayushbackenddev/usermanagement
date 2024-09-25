<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $value = $request->dob;

        $request->validate([
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'nullable|alpha|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => [
                'required',
                'string',
                'max:20',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'confirmed',
            ],
            'password_confirmation' => 'required|string|max:20|same:password',
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
            'pan_card' => [
                'required',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            ],
            'dob' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(21)->format('d-m-Y'),
                'after_or_equal:' . Carbon::now()->subYears(25)->format('d-m-Y'),
            ],
            'gender' => 'required|in:male,female,other',
            'address' => [
                'nullable',
                'max:200',
            ],
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.alpha'    => 'First name can only contain alphabetic characters.',
            'first_name.max'      => 'First name cannot exceed 50 characters.',
            'last_name.alpha'     => 'Last name can only contain alphabetic characters.',
            'last_name.max'       => 'Last name cannot exceed 50 characters.',
            'email.required' => 'The email is required.',
            'email.email'    => 'Invalid email address.',
            'email.max'      => 'The email address must not exceed 50 characters.',
            'email.unique'   => 'Email already exists.',
            'password.required' => 'Password is required.',
            'password.max' => 'Password cannot be more than 20 characters.',
            'password.regex'    => [
                'The password must contain at least one lowercase letter (a-z).',
                'The password must contain at least one uppercase letter (A-Z).',
                'The password must contain at least one digit (0-9).',
                'The password must contain at least one special character (@, $, !, %, *, #, ?, or &).',
            ],
            'mobile_number.required'  => 'The mobile number is required.',
            'mobile_number.numeric'   => 'Invalid mobile number.',
            'mobile_number.digits'    => 'The mobile number must be exactly 10 digits.',
            'mobile_number.unique'    => 'Mobile number already exits.',
            'pan_card.required' => 'The PAN card is required.',
            'pan_card.regex'    => 'The PAN card format is invalid. It should be in the format: 5 uppercase letters, 4 digits, and 1 uppercase letter (e.g., ABCDE1234F).',
            'dob.required' => 'The date of birth field is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'You must be at least 21 years old.',
            'dob.after_or_equal' => 'You must not be older than 25 years.',
            'address.max'      => 'The address cannot exceed 200 characters.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? '',
            'mobile_number' => $request->mobile_number,
            'pan_card' => $request->pan_card,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'address' => $request->address ?? '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('profile');
        }

        return back()->withErrors([
            'wrong_cred' => 'The provided credentials do not match our records.',
        ]);
    }

    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function profileUpdate(Request $request)
    {
        $user_id = base64_decode($request->user_id);
        $value = $request->dob;

        $request->validate([
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'nullable|alpha|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $user_id,
            // 'password' => [
            //     'required',
            //     'string',
            //     'max:20',
            //     'regex:/[a-z]/',
            //     'regex:/[A-Z]/',
            //     'regex:/[0-9]/',
            //     'regex:/[@$!%*#?&]/',
            //     'confirmed',
            // ],
            // 'password_confirmation' => 'required|string|max:20|same:password',
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,' . $user_id,
            'pan_card' => [
                'required',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            ],
            'dob' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(21)->format('d-m-Y'),
                'after_or_equal:' . Carbon::now()->subYears(25)->format('d-m-Y'),
            ],
            'gender' => 'required|in:male,female,other',
            'address' => [
                'nullable',
                'max:200',
            ],
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:1024',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.alpha'    => 'First name can only contain alphabetic characters.',
            'first_name.max'      => 'First name cannot exceed 50 characters.',
            'last_name.alpha'     => 'Last name can only contain alphabetic characters.',
            'last_name.max'       => 'Last name cannot exceed 50 characters.',
            'email.required' => 'The email is required.',
            'email.email'    => 'Invalid email address.',
            'email.max'      => 'The email address must not exceed 50 characters.',
            'email.unique'   => 'Email already exists.',
            // 'password.required' => 'Password is required.',
            // 'password.max' => 'Password cannot be more than 20 characters.',
            // 'password.regex'    => [
            //     'The password must contain at least one lowercase letter (a-z).',
            //     'The password must contain at least one uppercase letter (A-Z).',
            //     'The password must contain at least one digit (0-9).',
            //     'The password must contain at least one special character (@, $, !, %, *, #, ?, or &).',
            // ],
            'dob.required' => 'The date of birth field is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'You must be at least 21 years old.',
            'dob.after_or_equal' => 'You must not be older than 25 years.',
            'mobile_number.required'  => 'The mobile number is required.',
            'mobile_number.numeric'   => 'Invalid mobile number.',
            'mobile_number.digits'    => 'The mobile number must be exactly 10 digits.',
            'mobile_number.unique'    => 'Mobile number already exits.',
            'pan_card.required' => 'The PAN card is required.',
            'pan_card.regex'    => 'The PAN card format is invalid. It should be in the format: 5 uppercase letters, 4 digits, and 1 uppercase letter (e.g., ABCDE1234F).',
            'address.max'      => 'The address cannot exceed 200 characters.',
            'profile_image.image'  => 'The file must be an image.',
            'profile_image.mimes'  => 'The profile image must be a file of type: jpeg, png, jpg.',
            'profile_image.max'    => 'The profile image size should not exceed 1MB.',
        ]);

        $user = User::findOrFail($user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name ?? '';
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        $user->mobile_number = $request->mobile_number;
        $user->pan_card = $request->pan_card;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->address = $request->address ?? '';
        if ($request->hasFile('profile_image')) {
            $imageName = time().'.'.$request->profile_image->extension();
            $request->profile_image->move(public_path('profileImage'), $imageName);
            $user->profile_image = 'profileImage/'. $imageName;
        }
        $user->save();

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
