<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait ExportFiltersTrait
{
    /**
     * @param $query
     * @param integer $villageId
     * @param string $role
     *
     * @return mixed
     */
    public function userExportFilter($query, $villageId, $role)
    {
        if (!empty($villageId)) {
            $villageUsers = Village::find($villageId)->users->pluck('id')->toArray();
            $query->whereIn('id', $villageUsers);
        }

        if (!empty($role)) {
            $query->whereIn(
                'id',
                User::role($role)->pluck('id')->toArray()
            );
        }

        return $query;
    }

    /**
     * @param $query
     * @param $villageId
     * @param $dateFrom
     * @param $dateTo
     *
     * @return mixed
     */
    public function enquiryExportFilter($query, $villageId, $dateFrom, $dateTo)
    {
        /** Get the filter village id if not get all the villages belong to this user */
        if (!empty($villageId)) {
            $query->where('village_id', $villageId);
        }

        if (!empty($dateFrom)) {
            $query->whereDate(
                'created_at',
                '>=',
                Carbon::parse($dateFrom)
            );
        }

        if (!empty($dateTo)) {
            $query->whereDate(
                'created_at',
                '<=',
                Carbon::parse($dateTo)
            );
        }

        return $query;
    }

    /**
     * @param $query
     * @param $operator
     * @param $region
     * @param $district
     * @param $plan
     * @return mixed
     */
    public function villageExportFilter($query, $operator, $region, $district, $plan)
    {
        if (!empty($operator)) {
            $query->where('operator_id', $operator);
        }

        if (!empty($region)) {
            $query->join('addresses', 'villages.address_id', '=', 'addresses.id')
                ->where('addresses.region_id', $region);
        }

        if (!empty($district)) {
            if (empty($region)) {
                $query->join('addresses', 'villages.address_id', '=', 'addresses.id');
            }

            $query->where('addresses.district_id', $district);
        }

        if (!empty($plan)) {
            $query->where('plan_id', $plan);
        }

        return $query;
    }

    /**
     * @param $query
     * @param $operator
     * @param $region
     * @param $district
     *
     * @return mixed
     */
    public function careHomeExportFilter($query, $operator, $region, $district)
    {
        if (!empty($operator)) {
            $query->where('operator_id', $operator);
        }

        if (!empty($region)) {
//            $query->join('addresses', 'villages.address_id', '=', 'addresses.id')
//                ->where('addresses.region_id', $region);
        }

        if (!empty($district)) {
            if (empty($region)) {
                //$query->join('addresses', 'villages.address_id', '=', 'addresses.id');
            }

            //$query->where('addresses.district_id', $district);
        }

        return $query;
    }
}
