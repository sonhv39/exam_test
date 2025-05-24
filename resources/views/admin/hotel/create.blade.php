<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/create.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="page-wrapper create-page-wrapper">
        <h2 class="title">Hotel Registration</h2>
        <hr>
        <div class="create-form">
            <form action="{{ route('adminHotelCreateProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="hotel_name">Hotel Name</label>
                    <input type="text" name="hotel_name" id="hotel_name" value="{{ old('hotel_name') }}" required>
                    @error('hotel_name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prefecture_id">Prefecture</label>
                    <select name="prefecture_id" id="prefecture_id" required>
                        <option value="">Please select</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                                {{ $prefecture->prefecture_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Hotel Description</label>
                    <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hotel_type">Hotel Type</label>
                    <select name="hotel_type" id="hotel_type" required>
                        <option value="">Please select</option>
                        @foreach(App\Helper\CommonConst::HOTEL_TYPE_IMG as $type => $image)
                            <option value="{{ $type }}" {{ old('hotel_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }} Hotel
                            </option>
                        @endforeach
                    </select>
                    @error('hotel_type')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hotel_image_file">Hotel Image</label>
                    <input type="file" name="hotel_image_file" id="hotel_image_file" accept="image/*">
                    @error('hotel_image_file')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Register</button>
                    <a href="{{ route('adminHotelSearchPage') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
