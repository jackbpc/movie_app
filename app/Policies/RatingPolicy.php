<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;

class RatingPolicy
{
    /**
     * Determine if the given rating can be updated by the user.
     */
    public function update(User $user, Rating $rating)
    {
        return $user->is_admin || $user->id === $rating->user_id;
    }

    /**
     * Determine if the given rating can be deleted by the user.
     */
    public function delete(User $user, Rating $rating)
    {
        return $user->is_admin || $user->id === $rating->user_id;
    }
}
