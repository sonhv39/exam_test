<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <div class="title-wrapper">
            <h2 class="title">検索画面</h2>
        </div>
        <div class="search-hotel-name">
                <form action="{{ route('adminHotelSearchResult') }}" method="post" id="searchForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="hotel_name" value="{{ old('hotel_name') }}" placeholder="ホテル名">
                        <select name="prefecture_id">
                            <option value="">都道府県を選択</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                                    {{ $prefecture->prefecture_name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">検索</button>
                    </div>
                    <span class="error" id="errorMessage" style="display: none;">何も入力されていません</span>
                    @if(isset($error))
                        <span class="error">{{ $error }}</span>
                    @endif
                </form>
            </div>
    </div>
@endsection

@section('page_js')
    @vite(['resources/js/app.js'])
@endsection