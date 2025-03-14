<?php

namespace App\Models;

class Upload extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'uploads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'uploadable_id',
        'uploadable_type',
        'path',
        'file_name',
        'file_size',
        'extension'
    ];
}
