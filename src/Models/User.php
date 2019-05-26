<?php

namespace App\Models;

use App\Interfaces\MustVerifyAccount;
use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use mysql_xdevapi\Exception;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, MustVerifyAccount
{
    use Notifiable, HasRoles, \App\Traits\MustVerifyAccount;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'email_token',
        'email_verified_at',
        'photo',
        'parent_id',
        'created_by',
        'operator_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail($this));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token, $this));
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return sprintf('%s %s', ucfirst(strtolower($this->first_name)), ucfirst(strtolower($this->last_name)));
    }

    /**
     * @return string
     */
    public function fullNameInitial()
    {
        return sprintf('%s%s', substr($this->first_name, 0, 1), substr($this->last_name, 0, 1));
    }

    /**
     * Get the care homes associated with the user.
     *
     * @return BelongsToMany
     */
    public function careHomes()
    {
        return $this->belongsToMany(CareHome::class);
    }

    /**
     * @return File|HasOne
     */
    public function photo()
    {
        return $this->hasOne(File::class, 'id', 'photo_id');
    }

    /**
     * Get the file associated with the user.
     */

    /**
     * @return User|HasOne
     */
    public function parent()
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

    /**
     * Get the parent associated with the user.
     */

    /**
     * Get all the user accounts associated with this parent.
     *
     * @return mixed
     */
    public function accounts()
    {
        return $this->where('parent_id', $this->id)->orderBy('first_name')->get();
    }

    /**
     * @return User|HasOne
     */
    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Get the created by user associated with the user.
     */

    /**
     * Get the operator that owns the user.
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * @return Operator|BelongsTo
     */
    public function mainOperator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'id');
    }

    /**
     * @return string
     */
    public function first2VillageAndCount()
    {
        if ($this->hasRole('admin')) {
            $villageList = ($this->mainOperator) ? $this->mainOperator->villages : new Collection();
            $villageRelation = ($this->mainOperator) ? $this->mainOperator->villages() : new Collection();
        } else {
            $villageList = $this->villages;
            $villageRelation = $this->villages();
        }

        if ($villageList->count() > 2) {
            $otherVillageCount = ($villageRelation->count() - 2);
            $firstVillage = $villageRelation->orderBy('id')->limit(1)->offset(0)->first();
            $secondVillage = $villageRelation->orderBy('id')->limit(1)->offset(1)->first();
            return sprintf(
                '%s,<br>%s,<br> +%d other village%s',
                $firstVillage->name,
                $secondVillage->name,
                $otherVillageCount,
                ($otherVillageCount > 1) ? 's' : ''
            );
        }

        return implode(', <br>', $villageList->pluck('name')->toArray());
    }

    /**
     * Get the villages associated with the user.
     *
     * @return BelongsToMany
     */
    public function villages()
    {
        return $this->belongsToMany(Village::class);
    }
}
