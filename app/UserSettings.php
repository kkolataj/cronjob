<?php


namespace App;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class UserSettings extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'user_settings';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hasActiveNotifications'
    ];

    protected $casts = [
        'hasActiveNotifications' => 'boolean',
    ];
}
