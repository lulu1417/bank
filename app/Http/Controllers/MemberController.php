<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Record;
use Illuminate\Support\Facades\Auth;
use Str;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::orderBy('created_at', 'DESC')->paginate(5);
        dd($records);
        $member = [
            'account' => Auth::user()->account,
            'balance' => Auth::user()->balance,
        ];
        return $this->sendResponse($member, $records->toArray(), 'Records retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'account' => ['required', 'max:255', 'unique:members'],
                'password' => ['required', 'string', 'min:6', 'max:12'],
            ]);
            $apiToken = Str::random(10);
            $prize = 100;
            $create = Member::create([
                'account' => $request['account'],
                'password' => $request['password'],
                'api_token' => $apiToken,
                'balance' => $prize,
            ]);
            if ($create) {
                return "Register successfully, and you got $100. Your Token is $apiToken.";
            }
        } catch (Exception $e) {
            sendError($e, 'Registered failed.', 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'account' => ['string', 'unique:members'],
            'password' => ['string', 'min:6', 'max:12'],
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $member = Auth::user();
        if ($member->update($request->all())) {
            return $this->sendResponse($member->toArray(), 'Member updated successfully.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if ($member->delete()) {
            return $this->sendResponse($member->toArray(), 'Member deleted successfully.');
        }
    }
}
