<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentInvoice extends Model
{
    use HasFactory;

    // Doldurulabilir alanlar
    protected $fillable = [
        'company_id',
        'user_id',
        'shipment_id',
        'i_no',
        'author',
        'author_company',
        'customer',
        'upload_info',
        'delivery_info',
        'price',
        'vat',
        'net_gain',
        'download_token',
    ];

    // JSON alanları için casting
    protected $casts = [
        'author_company' => 'array',
        'customer' => 'array',
        'upload_info' => 'array',
        'delivery_info' => 'array',
    ];

    // Otomatik olarak created_at ve updated_at alanlarını kullanmak
    public $timestamps = true;

    // İlişkiler
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
