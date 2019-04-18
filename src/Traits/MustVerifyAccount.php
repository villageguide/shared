<?php

namespace App\Traits;

trait MustVerifyAccount
{
    /**
     * Determine if the admin has verified their account.
     *
     * @return bool
     */
    public function hasVerifiedAccount()
    {

        if ($this->hasRole('admin')) {
            $villageList = $this->mainOperator->villages;
        } else {
            $villageList = $this->villages;
        }

        foreach ($villageList as $village) {
            if ($village->status == 'Active') {
                return true;
            }
        }

        return false;
    }
}
