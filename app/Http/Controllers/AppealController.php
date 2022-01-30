<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LocationMiddleware;
use App\Models\Appeal;
use App\Models\CountryCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Stevebauman\Location\Facades\Location;


class AppealController extends Controller
{

    public function __construct()
    {



        $this->middleware(LocationMiddleware::class)->only('store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'language_codes' => 'required|exists:country_codes,id',
            'phone_codes' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email:rfc,dns',
            'country' => 'required|exists:country_codes,id',
            'referances_id' => 'required|exists:referances,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (CountryCodes::find($request->country)->dial_code != $request->phone_codes) {
            return response()->json("Ülke seçimi ve telefon kod seçimi uyuşmamaktadır ! Example: +90",  421);
        }
        return Appeal::create($request->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    protected function appeals_join_referances_and_country_codes()
    {
        return DB::table("appeals")
            ->join("country_codes", "country_codes.id", "=", "appeals.language_codes")
            ->join("referances", "referances.id", "=", "appeals.referances_id")
            ->where("appeals.created_at", ">", now()->subDays(7)->toDateString())
            ->select("appeals.*", "appeals.created_at as appeals_created_at", "country_codes.*", "referances.name as referances_name");
    }
    public function order(Request $request)
    {
        $data = null;
        switch ($request->data) {
            case 'referance':
                $data =  $this->appeals_join_referances_and_country_codes()->orderBy("appeals.referances_id")->get();
                break;
            case 'language':
                $data =  $this->appeals_join_referances_and_country_codes()->orderBy("country_codes.code")->get();
                break;
            default:
                return response()->json(false);
                break;
        }
        return response()->json($data);
    }
}
