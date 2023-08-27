<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone_number', 'email', 'desired_budget', 'message'
    ];

    // Accessor to get the label for the status
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status']; // Assuming 'status' is the column name

        // Define your label mappings based on the status values
        $statusLabels = [
            1 => 'New',
            2 => 'User Created',
            3 => 'User Aleady Exists',
        ];

        // Return the label if it exists in the mapping, otherwise return the original status
        return $statusLabels[$status] ?? '';
    }
}
