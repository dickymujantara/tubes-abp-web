<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfp;
use App\Models\RfpList;
use App\Models\RfpPhoto;
use App\Models\RfpLog;
use App\Models\Media;
use App\Models\Notification;
use Auth;

class RfpController extends Controller
{
    protected $size = 10;
    protected $code = 200;

    public function listRfp(Request $request)
    {
        try {
            $response = [];

            $data = Rfp::select('rfps.*', 'projects.project_name' ,'profiles.fullname')
                    ->join('projects', 'projects.id', '=' , 'rfps.id_project')
                    ->join('users', 'rfps.id_user', '=', 'users.id')
                    ->join('profiles', 'profiles.id_user', '=', 'users.id')
                    ->where(["rfps.id_user" => Auth::user()->id])->orderBy("rfps.id",'desc')->paginate($request->size);

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpDetail(Request $request)
    {
        try {
            $response = [];

            $data = Rfp::select('rfps.*', 'projects.project_name' ,'profiles.fullname')
                    ->join('projects', 'projects.id', '=' , 'rfps.id_project')
                    ->join('users', 'rfps.id_user', '=', 'users.id')
                    ->join('profiles', 'profiles.id_user', '=', 'users.id')
                    ->where(["rfps.id" => $request->id])->first();

            $items = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
                    ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
                    ->where('id_rfp',$data->id)->get();

            $attach = RfpPhoto::select('rfp_photos.*','media.path_photo','media.label','media.description')
                    ->join('media', 'rfp_photos.id_media', '=', 'media.id')
                    ->where('id_rfp',$data->id)->get();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;
            $response['data']['items'] = $items;
            $response['data']['attach'] = $attach;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpDetailItems(Request $request)
    {
        try {
            $response = [];

            $data = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
            ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
            ->where('id_rfp',$request->id)->orderBy("rfp_lists.id",'desc')->get();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpDetailItemsPage(Request $request)
    {
        try {
            $response = [];

            $data = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
            ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
            ->where('id_rfp',$request->id)->orderBy("rfp_lists.id",'desc')->paginate($request->size);

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpItem(Request $request)
    {
        try {
            $response = [];

            $data = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
            ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
            ->where('rfp_lists.id',$request->id)->first();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpListAttach(Request $request)
    {
        try {
            $response = [];

            $data = RfpPhoto::select('rfp_photos.*','media.path_photo','media.label','media.description')
                ->join('media', 'rfp_photos.id_media', '=', 'media.id')
                ->where('id_rfp',$request->id)->get();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function RfpLog(Request $request)
    {
        try {
            $response = [];

            $data = RfpLog::select()->where(["id_rfp" => $request->id])->orderBy("id",'desc')->paginate($request->size);

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Excpetion $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function createRfp(Request $request)
    {
        try {
            $rfp = Rfp::create([
                "id_user" => Auth::user()->id,
                "id_project" => $request->project,
                "no_rfp" => $request->noRfp,
                "headline" => $request->headline,
                "type" => $request->type,
                "description" => $request->desc,
                "total_amount" => $request->totalAmount,
                "status" => 1
            ]);

            if ($rfp->save()) {
                foreach ($request->items as $value) {
                    $item =  RfpList::create([
                        "id_rfp" => $rfp->id,
                        "id_account" => $value["id_bank"],
                        "code_rfp" => $value["code_rfp"],
                        "invoice_number" => $value["invoice_number"],
                        "vendor_name" => $value["vendor"],
                        "date_transaction" => $value["date_transaction"],
                        "due_date_transaction" => $value['due_date_transaction'],
                        "description" => $value["description"],
                        "amount" => $value['amount']
                    ]);
                }

                foreach ($request->attachments as $value) {
                    $media = Media::create([
                        "path_photo" => $value["src"],
                    ]);

                    if ($media->save()) {
                        $attach =  RfpPhoto::create([
                            "id_rfp" => $rfp->id,
                            "id_media" => $media->id,
                            "status" => 1
                        ]);
                    }

                }
                
                $notif = Notification::create([
                    "id_user_to" => Auth::user()->id,
                    "id_user_from" => Auth::user()->id,
                    "title" => "Request For Payment",
                    "message" => "Success to Created RFP!"
                ]);

                $logs = RfpLog::create([
                    "id_rfp" => $rfp->id,
                    "title" => "Create RFP",
                    "message" => "Create RFP Successfully",
                    "status" => 1
                ]);

                if ($notif->save() && $logs->save()) {
                    $data = Rfp::select('rfps.*', 'projects.project_name' ,'profiles.fullname')
                            ->join('projects', 'projects.id', '=' , 'rfps.id_project')
                            ->join('users', 'rfps.id_user', '=', 'users.id')
                            ->join('profiles', 'profiles.id_user', '=', 'users.id')
                            ->where(["rfps.id" => $rfp->id])->first();

                    $items = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
                    ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
                    ->where('id_rfp',$rfp->id)->get();
        
                    $attach = RfpPhoto::select('rfp_photos.*','media.path_photo','media.label','media.description')
                            ->join('media', 'rfp_photos.id_media', '=', 'media.id')
                            ->where('id_rfp',$rfp->id)->get();
        
                    $response['code'] = $this->code;
                    $response['message'] = "Success";
                    $response['data'] = $data;
                    $response['data']['items'] = $items;
                    $response['data']['attach'] = $attach;

                    return response()->json($response, 200);
                }

            }

        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }

    public function updateRfp(Request $request)
    {
        try {
            $response = [];

            $update = Rfp::where('id', $request->id)->update([
                "id_project" => $request->project,
                "no_rfp" => $request->noRfp,
                "headline" => $request->headline,
                "type" => $request->type,
                "description" => $request->desc,
                "status" => 1
            ]);

            $notif = Notification::create([
                "id_user_to" => Auth::user()->id,
                "id_user_from" => Auth::user()->id,
                "title" => "Request For Payment",
                "message" => "Success to Update RFP!"
            ]);

            $logs = RfpLog::create([
                "id_rfp" => $request->id,
                "title" => "Update RFP",
                "message" => "Update RFP Successfully",
                "status" => 1
            ]);

            if ($update == 1 && $notif->save() && $logs->save()) {
                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $update;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
    
    public function updateTotalAmountRfp(Request $request)
    {
        try {
            $response = [];

            $update = Rfp::where('id', $request->id)->update([
                "total_amount" => $request->totalAmount,
            ]);

            if ($update == 1) {
                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $update;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function createDetailRfp(Request $request)
    {
        try {
            $response = [];

            $create = RfpList::create([
                "id_rfp" => $request->id,
                "code_rfp" => $request->code_rfp,
                "id_account" => $request->id_bank,
                "invoice_number" => $request->invoice_number,
                "vendor_name" => $request->vendor,
                "date_transaction" => $request->date_transaction,
                "due_date_transaction" => $request->due_date_transaction,
                "description" => $request->description,
                "amount" => $request->amount
            ]);

            if ($create->save()) {
                $data = RfpList::select('rfp_lists.*', 'bank_accounts.bank_number', 'bank_accounts.bank_name', 'bank_accounts.bank_user_name')
                        ->join('bank_accounts', 'bank_accounts.id', '=' ,'rfp_lists.id_account')
                        ->where('rfp_lists.id',$create->id)->first();

                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $data;
            }

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateDetailRfp(Request $request)
    {
        try {
            $response = [];

            $update = RfpList::where('id', $request->id)->update([
                "id_account" => $request->id_bank,
                "invoice_number" => $request->invoice_number,
                "vendor_name" => $request->vendor,
                "date_transaction" => $request->date_transaction,
                "due_date_transaction" => $request->due_date_transaction,
                "description" => $request->description,
                "amount" => $request->amount
            ]);

            if ($update == 1) {
                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $update;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function deleteDetailRfp(Request $request)
    {
        try {
            $delete = RfpList::where('id',$request->id)->delete();

            if ($delete == 1) {
                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $delete;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function createAttachRfp(Request $request)
    {
        try {
            $response = [];

            $media = Media::create([
                "path_photo" => $request->src,
            ]);

            if ($media->save()) {
                $attach =  RfpPhoto::create([
                    "id_rfp" => $request->id,
                    "id_media" => $media->id,
                    "status" => 1
                ]);

                if ($attach->save()) {
                    $response['code'] = $this->code;
                    $response['message'] = "Success";
                    $response['data'] = $attach;
                }

                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function deleteAttachRfp(Request $request)
    {
        try {
            $delete = RfpPhoto::where('id',$request->id)->delete();

            if ($delete == 1) {
                $response['code'] = $this->code;
                $response['message'] = "Success";
                $response['data'] = $delete;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

}
