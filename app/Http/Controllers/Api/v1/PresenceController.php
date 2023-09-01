<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\PresenceRequest\PresenceRequest;
use App\Traits\PaginateHelper;
use App\Traits\PaginateMetaData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresenceRequest\PresencePaginateRequest;
use App\Http\Resources\Presence\PresenceCollection;
use App\Models\Presence;
use App\Traits\ApiWrapper;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PresenceController extends Controller
{
    use ApiWrapper, PaginateMetaData;
    // Reusable query
    // var: 
    // - usr: user
    // - presence_in: presence where type = in
    // - presence_out: presence where type = out
    private function querySelectAllData(string $customCondition = null)
    {
        return DB::select("
            select 
            usr.id as user_id, 
            usr.name, 
            to_char(presence_in.time, 'YYYY-MM-DD') as Tanggal, 
            to_char(presence_in.time, 'HH:MM::SS') as waktu_masuk, 
            to_char(presence_out.time, 'HH:MM::SS') as waktu_pulang, 
            (case when presence_in.is_approved
            then
            'Approved'
            else
            'REJECT'
            end) as status_masuk,
            (case when presence_out.is_approved
            then
            'Approved'
            else
            'REJECT'
            end) as status_pulang
            from presences presence_in 
            left join 
            (select * from presences where type = 'OUT' and deleted_at is null) presence_out 
            on to_char(presence_in.time, 'YYYY-MM-DD') = to_char(presence_out.time, 'YYYY-MM-DD') 
            and presence_in.user_id = presence_out.user_id 
            left join users as usr
            on usr.id = presence_in.user_id 
            where presence_in.type = 'IN' 
        " . ($customCondition ? 'and ' . $customCondition : ""));
    }

    public function index()
    {
        try {
            $result = $this->querySelectAllData();
            if ($result) {
                return $this->successResponse($result);
            }
        } catch (Exception $e) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function myPresence()
    {
        try {
            $result = $this->querySelectAllData("usr.id = '" . Auth::user()->id . "'");
            if ($result) {
                return $this->successResponse($result);
            }
        } catch (Exception $e) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function myPresenceApproval()
    {
        try {
            $result = $this->querySelectAllData("usr.supervisor_npp = '" . Auth::user()->npp . "'");
            if ($result) {
                return $this->successResponse($result);
            }
        } catch (Exception $e) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function store(PresenceRequest $request)
    {
        try {
            $validated = $request->validated();
            if (now()->toDate()->format('Y-m-d') != date_create_from_format("Y-m-d\\TH:i:s.v\\Z", $validated['time'])->format('Y-m-d')) {
                return $this->errorResponse(Response::HTTP_BAD_REQUEST, "You cannot insert data at that time");
            }
            $validated['user_id']     = Auth::user()->id;
            $validated['is_approved'] = false;
            $result                   = Presence::create($validated);
            if ($result) {
                return $this->successResponse($result);
            }
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);
        } catch (Exception $e) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function approve($id)
    {
        $currentPresence = Presence::with('user')->find($id);
        if ($currentPresence->user->supervisor_npp != Auth::user()->npp) {
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, "You Don't have permission to approve that data");
        }
        $result = $currentPresence->update([
            'is_approved' => true,
        ]);
        if ($result) {
            return $this->successResponse($result);
        }
        return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

    }

    private function paginate(PresencePaginateRequest $request)
    {
        $validated = $request->validated();
        $presences = Presence::with('user')->when((!$request->missing('order_by') ? array_search($request->order_by, ['type', 'is_approved']) !== false : false), function ($q) use ($validated, $request) {
            // sort
            if (!$request->missing('order')) {
                return $q->orderBy($validated['order_by'], $validated['order']);
            } else {
                return $q->orderBy($validated['order_by'], 'asc');
            }
        })->when($request->missing('order_by'), function ($q) {
            $q->orderBy('created_at', 'desc');
        })->when(!$request->missing('q'), function ($q) use ($validated) {
            // search
            $q->where(
                function ($q) use ($validated) {
                    $q->whereHas('user', function ($q) use ($validated) {
                        $q->whereRaw('lower(users.name) like ' . "'%" . strtolower($validated['q']) . "%'");
                    });
                }
            );
        });

        // filter type
        if (!$request->missing('type')) {
            $types     = explode(",", $validated['type']);
            $presences = $presences->whereIn('type', $types);
        }

        // order_by with relation
        switch ((!$request->missing('order_by') ? $request->order_by : '')) {
            case 'name':
                $presences = $presences->leftJoin('users', 'users.id', '=', 'presences.user_id')
                    ->select('presences.*')
                    ->orderBy("users.name", !$request->missing('order') ? $request->order : "asc");
                break;
            default:
                # code...
                break;
        }

        return $presences;
    }
    public function indexPaginate(PresencePaginateRequest $request)
    {
        $presences = $this->paginate($request);

        $presences = $presences->paginate($request->per_page ?? 15, ['*'], 'page', $request->current_page ?? 1);

        $formattedDatas = new PresenceCollection($presences);
        return $this->successResponse($formattedDatas, $this->getMetaData($presences));

    }
    public function myPresencePaginate(PresencePaginateRequest $request)
    {
        $presences = $this->paginate($request)->where('user_id', Auth::user()->id);

        $presences = $presences->paginate($request->per_page ?? 15, ['*'], 'page', $request->current_page ?? 1);

        $formattedDatas = new PresenceCollection($presences);
        return $this->successResponse($formattedDatas, $this->getMetaData($presences));

    }
    public function myPresenceApprovalPaginate(PresencePaginateRequest $request)
    {
        $presences = $this->paginate($request)->whereHas('user', function ($q) {
            $q->whereRaw("users.supervisor_npp = " . Auth::user()->npp);
        });

        $presences = $presences->paginate($request->per_page ?? 15, ['*'], 'page', $request->current_page ?? 1);

        $formattedDatas = new PresenceCollection($presences);
        return $this->successResponse($formattedDatas, $this->getMetaData($presences));

    }
}