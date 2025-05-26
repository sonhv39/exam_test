@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/booking.scss')
@endsection

@section('main_contents')
<div class="booking-search-page-wrapper">
    <h2>予約情報検索</h2>
    <div class="booking-search-form">
        <form action="{{ route('adminBookingSearchResult') }}" method="post">
            @csrf
            <div class="input-group">
                <input type="text" name="customer_name" placeholder="顧客名" value="{{ old('customer_name') }}">
                <input type="text" name="customer_contact" placeholder="顧客連絡先" value="{{ old('customer_contact') }}">
                <input type="date" name="checkin_time" placeholder="チェックイン日時" value="{{ old('checkin_time') }}">
                <input type="date" name="checkout_time" placeholder="チェックアウト日時" value="{{ old('checkout_time') }}">
                <button type="submit">検索</button>
            </div>
        </form>
    </div>

    @if(isset($bookings) && count($bookings) > 0)
    <div class="booking-result-list">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>顧客名</th>
                    <th>顧客連絡先</th>
                    <th>チェックイン日時</th>
                    <th>チェックアウト日時</th>
                    <th>予約日時</th>
                    <th>情報更新日時</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_contact }}</td>
                    <td>{{ $booking->checkin_time }}</td>
                    <td>{{ $booking->checkout_time }}</td>
                    <td>{{ $booking->created_at }}</td>
                    <td>{{ $booking->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(isset($bookings))
        <p class="no-results">No bookings found.</p>
    @endif
</div>
@endsection