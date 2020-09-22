<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\RawReleases
 *
 * @property int $id
 * @property string $release
 * @property string $status
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RawReleasesModel whereUpdatedAt($value)
 */
	class RawReleases extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

