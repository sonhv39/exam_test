@extends('common.admin.base')

@section('custom_css')
    @vite(['resources/scss/admin/result.scss'])
@endsection

@section('main_contents')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="result-page-wrapper">
        <h1 class="title">Hotel Search Results</h1>
        
        @if(count($hotelList) > 0)
            <table class="hotel-table">
                <thead>
                    <tr>
                        <th>Hotel Name</th>
                        <th>Prefecture</th>
                        <th>Hotel Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hotelList as $hotel)
                        <tr data-hotel-id="{{ $hotel['hotel_id'] }}">
                            <td>{{ $hotel['hotel_name'] }}</td>
                            <td>{{ $hotel['prefecture']['prefecture_name'] }}</td>
                            <td>{{ $hotel['hotel_type'] }}</td>
                            <td class="actions">
                                <a href="{{ route('adminHotelEdit', ['id' => $hotel['hotel_id']]) }}" class="btn-edit">Edit</a>
                                <button type="button" 
                                        class="btn-delete" 
                                        data-hotel-id="{{ $hotel['hotel_id'] }}"
                                        data-hotel-name="{{ $hotel['hotel_name'] }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-results">No hotels found.</p>
        @endif

        <div class="form-actions">
            <a href="{{ route('adminHotelSearchPage') }}" class="btn-back">Back to Search</a>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this hotel?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelDelete">Cancel</button>
                <button type="button" class="btn-confirm" id="confirmDelete">OK</button>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    @vite(['resources/js/app.js'])
@endsection