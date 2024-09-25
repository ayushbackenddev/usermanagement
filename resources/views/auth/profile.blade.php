<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="edit-profile-container">
        <!-- Logout Button -->
        <div class="logout-button">
            <a href="{{ url('logout') }}" type="button" class="btn btn-danger">Logout</a>
        </div>

        <h2>Edit Profile</h2>

        <!-- Display Current Profile Image -->
        <div class="profile-image">
            @if ($user->profile_image)
                <img src="{{ asset($user->profile_image) }}" alt="Profile Image" />
            @else
                <img src="{{ asset('profileImage/default_profile.jpg') }}" alt="Default Profile Image" />
            @endif
        </div>

        <form method="POST" action="{{ route('profile_update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ base64_encode($user->id) }}" name="user_id">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}">
            </div>
            @error('first_name') <div class="error">{{ $message }}</div> @enderror

            @if (!empty($user->last_name))
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}">
                </div>
                @error('last_name') <div class="error">{{ $message }}</div> @enderror
            @endif

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}">
            </div>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="password">Password <span class="required-asterisk">*</span></label>
                <input type="password" id="password" name="password" value="{{ $user->password }}">
            </div>
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="password_confirmation">Confirm Password <span class="required-asterisk">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" value="{{ $user->password }}">
            </div>
            @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" id="mobile_number" name="mobile_number" value="{{ $user->mobile_number }}">
            </div>
            @error('mobile_number') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="pan_card">PAN Card</label>
                <input type="text" id="pan_card" name="pan_card" value="{{ $user->pan_card }}">
            </div>
            @error('pan_card') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="{{ $user->dob }}">
            </div>
            @error('dob') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender">
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            @error('gender') <div class="error">{{ $message }}</div> @enderror

            @if (!empty($user->address))
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="4">{{ $user->address }}</textarea>
                </div>
                @error('address') <div class="error">{{ $message }}</div> @enderror
            @endif

            <div class="form-group">
                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">
            </div>
            @error('profile_image') <div class="error">{{ $message }}</div> @enderror

            <div class="form-group">
                <button type="submit">Update Profile</button>
            </div>
        </form>
    </div>
</body>
</html>
