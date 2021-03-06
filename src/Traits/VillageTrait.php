<?php

namespace App\Traits;

use App\Models\CareHome;
use App\Models\Country;
use App\Models\DefaultLegalTitle;
use App\Models\DefaultLevelOfCare;
use App\Models\District;
use App\Models\Operator;
use App\Models\Plan;
use App\Models\Region;
use App\Models\TypesOfHome;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

trait VillageTrait
{
    /**
     * @return array
     */
    public function countryList()
    {
        return Country::OrderBy('name')->pluck('name', 'id');
    }

    /**
     * @return array
     */
    public function countryNZOnly()
    {
        return Country::where('code', 'NZ')->orderBy('name')->pluck('name', 'id');
    }

    /**
     * @return array
     */
    public function getEntryAgeList()
    {
        return [
            55 => '55+',
            60 => '60+',
            65 => '65+',
            70 => '70+',
            75 => '75+',
        ];
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getPluckByName($name)
    {
        $class = 'App\Models\\' . $name;

        return $class::pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @param string $name
     * @param $options
     * @param integer $objectId
     * @param string $objectFieldName
     */
    public function saveCheckboxOptions($request, $name, $options, $objectId, $objectFieldName)
    {
        $defaultOptions = $request->input($name . '_default_option');
        $customOptions = $request->has($name . '_custom_option') ?
            $request->input($name . '_custom_option') :
            [$request->input($name . '_option')];

        $insert = [];
        $delete = [];

        if ($options->count() > 0) {
            foreach ($options as $option) {
                $optionName = $option->name;
                if (is_array($defaultOptions) && !in_array($optionName, $defaultOptions)
                    && !in_array($optionName, $customOptions)) {
                    $delete[] = $option->id;
                } elseif (is_array($defaultOptions) && in_array($optionName, $defaultOptions)) {
                    if (($key = array_search($optionName, $defaultOptions)) !== false) {
                        unset($defaultOptions[$key]);
                    }
                } elseif (is_array($customOptions) && in_array($optionName, $customOptions)) {
                    if (($key = array_search($optionName, $customOptions)) !== false) {
                        unset($customOptions[$key]);
                    }
                } else {
                    $delete[] = $option->id;
                }
            }
        }

        if (is_array($defaultOptions)) {
            foreach ($defaultOptions as $option) {
                $insertArray = [
                    'name'           => $option,
                    'is_default'     => true,
                    $objectFieldName => $objectId,
                ];
                if ($name == 'level-of-care') {
                    $defaultCare = DefaultLevelOfCare::where('name', $option)->first();
                    $insertArray['default_id'] = $defaultCare->id;
                }

                array_push($insert, $insertArray);
            }
        }

        if (is_array($customOptions)) {
            foreach ($customOptions as $option) {
                if (!empty($option)) {
                    array_push($insert, [
                        'name'           => $option,
                        'is_default'     => false,
                        $objectFieldName => $objectId,
                    ]);
                }
            }
        }

        $name = str_replace('-', ' ', $name);
        $object = 'App\Models\\' . str_replace(' ', '', ucwords($name));

        if (count($insert) > 0) {
            $object::insert($insert);
        }

        if (count($delete) > 0) {
            if ($name == 'types-of-homes') {
                foreach ($delete as $id) {
                    $typesOfHome = TypesOfHome::find($id);

                    foreach ($typesOfHome->photos as $photo) {
                        $photo->file->delete();
                    }
                }
            }

            $object::whereIn('id', $delete)->delete();
        }
    }

    /**
     * @param Village|CareHome $object
     * @param string $name
     *
     * @return array
     */
    public function userOptions($object, $name)
    {
        return $object->$name
            ->where('is_default', 1)
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * @return array
     */
    public function villageListData()
    {
        $data = [
            'activeVillages' => $this->user->villages()->where('status', 'Active')->orderBy('name')->get(),
            'draftVillages'  => $this->user->villages()->where('status', 'Draft')->orderBy('name')->get(),
            'regionList'     => $this->regionList(),
            'districtList'   => $this->districtList(),
            'planList'       => Plan::orderBy('name')->pluck('name', 'id')->toArray(),
            'operatorList'   => $this->operatorList(),
        ];

        if ($this->user->hasRole('admin')) {
            $data['activeVillages'] = $this->user->mainOperator->villages()
                ->where('status', 'Active')
                ->orderBy('name')
                ->get();
            $data['draftVillages'] = $this->user->mainOperator->villages()
                ->where('status', 'Draft')
                ->orderBy('name')
                ->get();
        }

        if ($this->user->hasRole('super-admin')) {
            $data['activeVillages'] = Village::where('status', 'Active')->OrderBy('name')->get();
            $data['suspendedVillages'] = Village::where('status', 'Suspended')->OrderBy('name')->get();
            $data['draftVillages'] = Village::where('status', 'Draft')->OrderBy('name')->get();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function regionList()
    {
        return Region::orderBy('name')->pluck('name', 'id');
    }

    /**
     * @return array
     */
    public function districtList()
    {
        return District::orderBy('name')->pluck('name', 'id');
    }

    /**
     * @return array
     */
    public function operatorList()
    {
        return Operator::where('status', 'Active')->orderBy('name')->pluck('name', 'id')->toArray();
    }

    /**
     * @return array
     */
    public function careHomeListData()
    {
        $data = [
            'regionList'   => $this->regionList(),
            'districtList' => $this->districtList(),
        ];

        if ($this->user->hasRole('super-admin')) {
            $data['operatorList'] = $this->operatorList();
            $data['activeCareHomes'] = CareHome::where('status', 'Active')->OrderBy('name')->get();
            $data['suspendedCareHomes'] = CareHome::where('status', 'Suspended')->OrderBy('name')->get();
            $data['draftCareHomes'] = CareHome::where('status', 'Draft')->OrderBy('name')->get();
        } elseif ($this->user->hasRole('admin')) {
            $data['activeCareHomes'] = $this->user->mainOperator->careHomes()
                ->where('status', 'Active')
                ->OrderBy('name')
                ->get();
            $data['draftCareHomes'] = $this->user->mainOperator->careHomes()
                ->where('status', 'Draft')
                ->OrderBy('name')
                ->get();
        } else {
            $data['activeCareHomes'] = $this->user->careHomes()->OrderBy('name')
                ->where('status', 'Active')
                ->OrderBy('name')
                ->get();
            $data['draftCareHomes'] = $this->user->careHomes()
                ->where('status', 'Draft')
                ->OrderBy('name')
                ->OrderBy('name')
                ->get();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function userListData()
    {
        $data = [
            'activeUsers'  => $this->user->operator
                ->users()
                ->whereNotNull('email_verified_at')
                ->OrderBy('first_name')
                ->get(),
            'pendingUsers' => $this->user->operator
                ->users()
                ->whereNull('email_verified_at')
                ->OrderBy('first_name')
                ->get(),
            'villageList'  => $this->user->parent->villages()->orderBy('name')->get(),
            'operatorList' => $this->operatorList(),
            'operatorID'   => $this->user->operator_id,
        ];

        if ($this->user->hasRole('super-admin')) {
            $data['villageList'] = Village::where('status', 'Active')->orderBy('name')->get();
            $superAdminList = Role::where('name', 'super-admin')->first()->users->pluck('id')->toArray();
            $data['activeUsers'] = User::whereNotIn('id', $superAdminList)
                ->whereNotNull('email_verified_at')
                ->orderBy('first_name')
                ->get();
            $data['pendingUsers'] = User::whereNotIn('id', $superAdminList)
                ->whereNull('email_verified_at')
                ->orderBy('first_name')
                ->get();
            $data['operatorID'] = '';
        }

        return $data;
    }

    /**
     * @return array
     */
    public function imagesForLightBox()
    {
        $photoArray = [];
        // if more than one video load all first and then images.
        if ($this->videos->count() > 1) {
            foreach ($this->videos as $video) {
                $this->addLightBoxArray($photoArray, $video, true);
            }

            foreach ($this->photos as $photo) {
                $this->addLightBoxArray($photoArray, $photo, false);
            }

            return $photoArray;
        }  else if ($this->videos->count() == 1) {
            // if only one video load in the middle(2nd)
            if ($this->photos->first()) {
                $this->addLightBoxArray($photoArray, $this->photos->first(), false);
            }
            $this->addLightBoxArray($photoArray, $this->videos->first(), true);

            foreach ($this->photos as $key => $photo) {
                if ($key == 0) {
                    continue; // skip the first image
                }
                $this->addLightBoxArray($photoArray, $photo, false);
            }

            return $photoArray;
        }

        foreach ($this->photos as $photo) {
            $this->addLightBoxArray($photoArray, $photo, false);
        }

        return $photoArray;
    }

    /**
     * @param $photoArray
     * @param $obj
     * @param $isVideo
     */
    private function addLightBoxArray(&$photoArray, $obj, $isVideo)
    {
        if ($isVideo) {
            if (!$obj->thumb) {
                return;
            }
            $src = '';
            if ($obj->type == 'youtube') {
                $src = sprintf('https://www.youtube.com/watch?v=%s', $obj->link);
            } elseif ($obj->type == 'vimeo') {
                $src = sprintf('https://vimeo.com/%s', $obj->link);
            }
            $thumb = asset($obj->thumb->resize(120, 90));
        } else {
            if (!$obj->file) {
                return;
            }

            $src = asset($obj->file->widen(1100, 607));
            $thumb = asset($obj->file->resize(120, 90));
        }

        array_push(
            $photoArray,
            [
                'thumb' => $thumb,
                'src'   => $src,
            ]
        );
    }

    /**
     * @return array
     */
    public function imagesForTinySlider()
    {
        $photoArray = [];

        // if more than one video load all first and then images.
        if ($this->videos->count() > 1) {
            foreach ($this->videos as $video) {
                if (!file_exists($video->thumb->filepath)) {
                    continue;
                }
                $this->addTinySliderArray($photoArray, $video, true);
            }

            foreach ($this->photos as $photo) {
                if (!file_exists($photo->file->filepath)) {
                    continue;
                }

                $this->addTinySliderArray($photoArray, $photo, false);
            }

            return $photoArray;
        }  else if ($this->videos->count() == 1) {
            // if only one video load in the middle(2nd)
            if ($this->photos->first()) {
                $photo = $this->photos->first();

                $this->addTinySliderArray($photoArray, $photo, false);
            }

            $this->addTinySliderArray($photoArray, $this->videos->first(), true);

            foreach ($this->photos as $key => $photo) {
                if ($key == 0) {
                    continue; // skip the first image
                }

                $this->addTinySliderArray($photoArray, $photo, false);
            }

            return $photoArray;
        }

        foreach ($this->photos as $photo) {
            $this->addTinySliderArray($photoArray, $photo, false);
        }

        return $photoArray;
    }

    /**
     * @param $photoArray
     * @param $obj
     * @param $isVideo
     */
    private function addTinySliderArray(&$photoArray, $obj, $isVideo)
    {
        if ($isVideo) {
            if (!$obj->thumb) {
                return;
            }

            $title = $obj->thumb->title;
            $src = asset($obj->thumb->resizeVideo(480, 350));

        } else {
            if (!$obj->file) {
                return;
            }

            $title = $obj->file->title;
            $src = asset($obj->file->resize(480, 350));
        }

        array_push(
            $photoArray,
            [
                'title' => $title,
                'src'   => $src,
                'isVideo' => $isVideo,
            ]
        );
    }
}
