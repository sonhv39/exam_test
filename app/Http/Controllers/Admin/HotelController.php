<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CommonConst;
use App\Helper\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\hotel\CreateHotelRequest;
use App\Http\Requests\hotel\EditHotelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    protected $hotel;
    protected $prefecture;

    public function __construct(Hotel $hotel, Prefecture $prefecture)
    {
        $this->hotel = $hotel;
        $this->prefecture = $prefecture;
    }

    /** get methods */

    public function showSearch(): View
    {
        $prefectures = $this->prefecture->all();
        return view('admin.hotel.search', compact('prefectures'));
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit(int $id): View
    {
        $hotel = $this->hotel->findOrFail($id);
        $prefectures = $this->prefecture->all();
        $hotelTypes = array_keys(CommonConst::HOTEL_TYPE_IMG);
        return view('admin.hotel.edit', compact('hotel', 'prefectures', 'hotelTypes'));
    }

    public function showCreate(): View
    {
        $prefectures = $this->prefecture->all();
        return view('admin.hotel.create', compact('prefectures'));
    }

    public function showEditConfirm(Request $request): View
    {
        $hotel = $this->hotel->findOrFail($request->hotel_id);
        $prefecture = $this->prefecture->findOrFail($request->prefecture_id);

        $data = [
            'hotel_name' => $request->hotel_name,
            'prefecture_id' => $request->prefecture_id,
            'hotel_type' => $request->hotel_type,
            'description' => $request->description,
        ];

        // If there's a new image, upload it temporarily
        if ($request->hasFile('hotel_image_file')) {
            $data['hotel_image_file'] = CommonFunction::uploadFileImg($request->file('hotel_image_file'), 'hotel');
        }

        return view('admin.hotel.edit_confirm', compact('data', 'hotel', 'prefecture'));
    }

    /** post methods */

    public function searchResult(Request $request): View
    {
        $var = [];
        $hotelNameToSearch = $request->input('hotel_name');
        $prefectureId = $request->input('prefecture_id');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch, $prefectureId);
        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    public function create(CreateHotelRequest $request): RedirectResponse|View
    {
        try {
            $dataCreateHotel = $request->only(['hotel_name', 'prefecture_id', 'description', 'hotel_type', 'hotel_image_file']);
            $filePath = null;
            if (isset($dataCreateHotel['hotel_image_file'])) {
                // Upload hotel image to public/assets/img/hotel directory
                $filePath = CommonFunction::uploadFileImg($dataCreateHotel['hotel_image_file'], 'hotel');
            }

            // Create hotel record
            $hotel = $this->hotel->create([
                'hotel_name' => $dataCreateHotel['hotel_name'],
                'prefecture_id' => $dataCreateHotel['prefecture_id'],
                'description' => $dataCreateHotel['description'],
                'hotel_type' => $dataCreateHotel['hotel_type'],
                'hotel_image_path' => $filePath,
                'file_path' => CommonConst::HOTEL_TYPE_IMG[$dataCreateHotel['hotel_type']],
            ]);

            return redirect()->route('adminHotelSearchPage')
                ->with('success', 'Hotel has been successfully registered.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while registering the hotel.');
        }
    }

    public function delete(Request $request)
    {
        try {
            $hotel = Hotel::where('hotel_id', $request->hotel_id)->first();
            if (!$hotel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel not found'
                ], 404);
            }

            // Delete hotel image if exists
            if ($hotel->hotel_image_path) {
                $imagePath = public_path($hotel->hotel_image_path);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $hotel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hotel deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting hotel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {

        try {
            $hotel = Hotel::query()->where('hotel_id', $request->hotel_id)->first();
            if (!$hotel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel not found'
                ], 404);
            }

            // Validate request
            $validator = Validator::make($request->all(), [
                'hotel_name' => 'required|string|max:255',
                'prefecture_id' => 'required|exists:prefectures,prefecture_id',
                'hotel_type' => 'required|string',
                'description' => 'required|string',
                'hotel_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $hotel->hotel_name = $request->hotel_name;
            $hotel->prefecture_id = $request->prefecture_id;
            $hotel->hotel_type = $request->hotel_type;
            $hotel->description = $request->description;
            $hotel->file_path = CommonConst::HOTEL_TYPE_IMG[strtolower($request->hotel_type)];

            // Handle image upload if new image is provided
            if ($request->hasFile('hotel_image_file')) {
                $oldPath = $hotel->hotel_image_path;
                // Upload new image
                $filePath = CommonFunction::uploadFileImg($request->file('hotel_image_file'), 'hotel');
                
                // Delete old image if exists
                if (oldPath) {
                    $oldImagePath = public_path(oldPath);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                $hotel->hotel_image_path = $filePath;
            }

            $hotel->save();

            return response()->json([
                'success' => true,
                'message' => 'Hotel updated successfully',
                'redirect' => route('adminHotelEditComplete', ['id' => $hotel->hotel_id])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating hotel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showEditComplete($id)
    {
        $hotel = Hotel::query()->where('hotel_id', $id)->first();
        return view('admin.hotel.edit_complete', compact('hotel'));
    }
}
