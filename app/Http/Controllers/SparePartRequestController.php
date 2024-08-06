<?php
namespace App\Http\Controllers;

use App\Models\RepairSparePart;
use App\Models\RepairTicket;
use App\Models\SparePart;
use App\Models\SparePartRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SparePartRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        if (Auth::user()->role_id == 1)
        {
            $data['allSparePartRequests'] = DB::table('spare_part_requests')->select(DB::raw('MIN(spare_part_requests.id) as recordid') , 'spare_part_requests.ticket_number', 'spare_part_requests.created_at', DB::raw('MAX(users.name) as scname') , DB::raw('MAX(users.email) as scemail') , DB::raw('MAX(users.phoneno_1) as scphone'))
                ->join("users", "spare_part_requests.service_center_id", "=", "users.id")
                ->groupBy('spare_part_requests.ticket_number', 'spare_part_requests.created_at')
                ->get();

        }
        else if (Auth::user()->role_id == 4)
        {
            $data['allSparePartRequests'] = DB::table('spare_part_requests')->select(DB::raw('MIN(spare_part_requests.id) as recordid') , 'spare_part_requests.ticket_number', 'spare_part_requests.created_at', DB::raw('MAX(users.name) as scname') , DB::raw('MAX(users.email) as scemail') , DB::raw('MAX(users.phoneno_1) as scphone'))
                ->join("users", "spare_part_requests.service_center_id", "=", "users.id")
                ->where("spare_part_requests.service_center_id", Auth::user()
                    ->id)
                ->groupBy('spare_part_requests.ticket_number', 'spare_part_requests.created_at')
                ->get();

        }
        else
        {
            return redirect("dashboard");
        }

        $data['count'] = 1;
        $data['roleId'] = Auth::user()->role_id;

        return view('sparepartrequest.list', $data);
    }

    function generateSequentialNumber($number)
    {
        return str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function add()
    {

        if (Auth::user()->role_id == 4)
        {
            $count = SparePartRequest::count();
            $finalCount = $count +1;
            $data["randomString"] = 'SK'.date('y').$this->generateSequentialNumber($finalCount);
            //$data['randomString'] = Str::random(4);
            $data['allSpareParts'] = SparePart::where('status','active')->get();
            return view('sparepartrequest.add-request', $data);
        }
        else
        {
            return redirect("dashboard");

        }
    }
    public function save(Request $request)
    {
        if ($request->all())
        {

            DB::beginTransaction();
            try
            {
                if ($request->sparepart)
                {
                    for ($i = 0;$i < count($request->sparepart);$i++)
                    {
                        $requestedParts[] = ['ticket_number' => $request->request_number, 'sparepart_id' => $request->sparepart[$i], 'service_center_id' => Auth::user()->id, 'required_quantity' => $request->needed_stock[$i], 'created_at' => date('Y-m-d H:i') ];
                    }
                    SparePartRequest::insert($requestedParts);

                    return redirect("/sparepart-request-list")->with("status", "Spare Part Request Sent");
                }
                else
                {
                    return redirect()
                        ->route('add-sparepart-request')
                        ->with('status', 'Please select spare Part');
                }
            }
            catch(\Exception $e)
            {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect("/sparepart-request-list")->with("status", $e);
            }
        }
    }
    public function show($id)
    {

        $detail = SparePartRequest::where('ticket_number', $id)->first();

        if (!$detail)
        {
            return redirect('/sparepart-request-list')->with('status', 'No Record Found');
        }
        else
        {
            $detailSc = User::where('id', $detail->service_center_id)
                ->first();
            $neededSpareParts = SparePartRequest::select('spare_part_requests.required_quantity as need_qty', 'spare_parts.factory_code as sp_name')->join('spare_parts', 'spare_part_requests.sparepart_id', '=', 'spare_parts.id')
                ->where('spare_part_requests.ticket_number', $id)->get();
            $userRole = Auth::user()->role_id;
            return view('sparepartrequest.view-request', compact('detail', 'userRole', 'neededSpareParts', 'detailSc'));

        }
    }
}

