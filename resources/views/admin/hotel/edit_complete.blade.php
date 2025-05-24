<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite(['resources/scss/admin/edit.scss'])
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="edit-page-wrapper">
        <h1 class="title">Hotel Information Updated</h1>
        
        <div class="edit-form">
            <div class="hotel-card">
                <div class="hotel-image">
                    <img src="{{ asset($hotel->hotel_image_path ?? 'assets/img/' . \App\Helper\CommonConst::HOTEL_TYPE_IMG[strtolower($hotel->hotel_type)]) }}" alt="Hotel image">
                </div>
                <div class="hotel-info">
                    <h2 class="hotel-name">{{ $hotel->hotel_name }}</h2>
                    <div class="info-group">
                        <label>Prefecture</label>
                        <p>{{ $hotel->prefecture->prefecture_name }}</p>
                    </div>
                    <div class="info-group">
                        <label>Hotel Type</label>
                        <p>{{ $hotel->hotel_type }}</p>
                    </div>
                    <div class="info-group">
                        <label>Description</label>
                        <p>{{ $hotel->description }}</p>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('adminHotelSearchPage') }}" class="btn-submit">Back to List</a>
            </div>
        </div>
    </div>
@endsection 