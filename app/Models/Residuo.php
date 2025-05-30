<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Residuo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nombre',
        'descripcion',
        'peso',
        'estado',
        'user_id',
        'categoria_id',
        'lat',
        'lng',
        'inflamable',
        'peligroso',
        'biodegradable',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('residuo')
            ->setDescriptionForEvent(fn(string $eventName) => "Residuo fue {$eventName}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
