<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite(['resources/scss/admin/edit.scss'])
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="edit-page-wrapper">
        <h1 class="title">Edit Hotel Information</h1>
        
        <form id="editHotelForm" class="edit-form" method="post" action="{{ route('adminHotelUpdate') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hotel_id" id="hotel_id" value="{{ $hotel->hotel_id }}">

            <div class="form-group">
                <label for="hotel_name">Hotel Name</label>
                <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $hotel->hotel_name) }}" required>
                @error('hotel_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="prefecture_id">Prefecture</label>
                <select id="prefecture_id" name="prefecture_id" required>
                    <option value="">Please select</option>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}" 
                                {{ old('prefecture_id', $hotel->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
                @error('prefecture_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="hotel_type">Hotel Type</label>
                <select id="hotel_type" name="hotel_type" required>
                    @foreach($hotelTypes as $type)
                        <option value="{{ $type }}" 
                                data-image="{{ asset('assets/img/' . \App\Helper\CommonConst::HOTEL_TYPE_IMG[strtolower($type)]) }}"
                                data-file-path="{{ $hotel->file_path ? asset('assets/img/' . $hotel->file_path) : asset('assets/img/' . \App\Helper\CommonConst::HOTEL_TYPE_IMG[strtolower($type)]) }}"
                                {{ old('hotel_type', $hotel->hotel_type) == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('hotel_type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description', $hotel->description) }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="hotel_image_file">Hotel Image</label>
                <!-- @if($hotel->hotel_image_path) -->
                    <div class="current-image">
                        <img src="{{ asset($hotel->hotel_image_path) }}" alt="Current hotel image">
                    </div>
                <!-- @endif -->
                <input type="file" id="hotel_image_file" name="hotel_image_file" accept="image/*">
                <p class="help-text">Leave empty to keep the current image</p>
                @error('hotel_image_file')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Confirm Changes</button>
                <a href="{{ route('adminHotelSearchPage') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="hotel-card">
                <div class="hotel-image">
                    <img id="previewImage" src="" alt="Hotel preview">
                </div>
                <div class="hotel-info">
                    <h2 id="previewName" class="hotel-name"></h2>
                    <div class="info-group">
                        <label>Prefecture</label>
                        <p id="previewPrefecture"></p>
                    </div>
                    <div class="info-group">
                        <label>Hotel Type</label>
                        <p id="previewType"></p>
                    </div>
                    <div class="info-group">
                        <label>Description</label>
                        <p id="previewDescription"></p>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-submit">Update Hotel</button>
                <button type="button" class="btn-cancel" onclick="closePreview()">Cancel</button>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    @vite(['resources/js/app.js'])
@endsection
