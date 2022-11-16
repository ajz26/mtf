<?php

namespace Modules\Room\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Room\Services\RoomService;
use Illuminate\Contracts\Support\Renderable;

class RoomController extends Controller
{

    protected $roomService;
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->roomService->paginate();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        return $this->roomService->create($request->toArray());
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return $this->roomService->findById($id,['*'],['users']);
    }


    /**
     * Show the specified resource.
     * @param int $id
     */
    public function start($id)
    {
        return $this->roomService->start($id);
    }


    /**
     * Show the specified resource.
     * @param int $id
     */
    public function finish($id)
    {
        return $this->roomService->finish($id);
    }



    public function subscribe($id){
        $user_id         = Auth::user()->id;
        $invitation_code = request('invitation_code');
        return $this->roomService->subscribe_user($id,$user_id,$invitation_code);

    }

    public function unsubscribe($id,$user = null){

        $user_id = $user ?? Auth::user()->id;
        $force   = request('force',false);

        return $this->roomService->unsubscribe_user($id,$user_id,$force);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

}
