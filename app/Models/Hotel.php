<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    protected $fillable = [
        'hotel_name',
        'prefecture_id',
        'file_path',
        'description',
        'hotel_image_path',
        'hotel_type'
    ];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Search hotel by hotel name and prefecture
     *
     * @param string|null $hotelName
     * @param int|null $prefectureId
     * @return array
     */
    static public function getHotelListByName(string $hotelName = null, int $prefectureId = null): array
    {
        $query = Hotel::query()->with('prefecture');

        if ($hotelName) {
            $query->where('hotel_name', 'LIKE', '%' . $hotelName . '%');
        }

        if ($prefectureId) {
            $query->where('prefecture_id', $prefectureId);
        }

        return $query->get()->toArray();
    }

    public static function createHotel($data)
    {
        return Hotel::created($data);
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
