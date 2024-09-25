<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Create Your Account</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}">
            @error('first_name') <div class="error">{{ $message }}</div> @enderror

            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}">
            @error('last_name') <div class="error">{{ $message }}</div> @enderror

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Password</label>
            <input type="password" name="password">
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
            @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror

            <label>Mobile Number</label>
            <input type="text" name="mobile_number" value="{{ old('mobile_number') }}">
            @error('mobile_number') <div class="error">{{ $message }}</div> @enderror

            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}">
            @error('dob') <div class="error">{{ $message }}</div> @enderror

            <label>Gender</label>
            <select name="gender">
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            @error('gender') <div class="error">{{ $message }}</div> @enderror

            <label>PAN Card</label>
            <input type="text" name="pan_card" value="{{ old('pan_card') }}">
            @error('pan_card') <div class="error">{{ $message }}</div> @enderror

            <label>Address</label>
            <textarea name="address">{{ old('address') }}</textarea>
            @error('address') <div class="error">{{ $message }}</div> @enderror

            <button type="submit">Register</button>
        </form>
        <a href="{{ route('login') }}">Already have an account? Login here</a>
    </div>
</body>
</html>
