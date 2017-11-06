<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Repository\User\UsersRepository;
use App\Repository\Company\CompanyRepository;
use App\Repository\Profile\ProfileRepository;

class QueryController extends ApiController
{
    public function searchUser(Request $request)
    {
        $users = new UsersRepository();
        $data = $users->search($request->input('param'));

        if (!$data) {       
            return response()->json(['msg' => [['body' => 'No records found', 'type' => 'danger']]]);
        }
        if (!empty($data)) {
            return response()->json(['msg' => [['body' => $data, 'type' => 'success',]]]);
        }
    }

    public function searchCompany(Request $request)
    {
        $company = new CompanyRepository();
        $data = $company->search($request->input('param'));

        if (!$data) {       
            return response()->json(['msg' => [['body' => 'No records found', 'type' => 'danger']]]);
        }
        if (!empty($data)) {
            return response()->json(['msg' => [['body' => $data, 'type' => 'success',]]]);
        }
    }

    public function searchProfile(Request $request)
    {
        $profile = new ProfileRepository();
        $data = $profile->search($request->input('param'));

        if (!$data) {       
            return response()->json(['msg' => [['body' => 'No records found', 'type' => 'danger']]]);
        }
        if (!empty($data)) {
            return response()->json(['msg' => [['body' => $data, 'type' => 'success',]]]);
        }
    }
}