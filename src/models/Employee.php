<?php

namespace Bahraminekoo\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * @var array
     */
    protected $dates = ['doe'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'doe', 'manager_id'];

    /**
     * model kind : in this case employee (to use in json responses)
     * @var array
     */
    protected $appends = ['kind'];

    const KIND = 'employee';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Optionally, an employee can have a manager, who must be an existing employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Optionally, an employee can have a manager, who must be an existing employee
     * this relationship aims to get all managing employees belongs to this model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * model's kind : employee
     *
     * @return string
     */
    public function getKindAttribute()
    {
        return self::KIND;
    }

    /**
     * normalize the date value to the standard format used in the model and database
     *
     * @param $date
     * @return false|string
     */
    public static function normalizeDate($date) {
        return date('Y-m-d', strtotime($date));
    }
}
