<?php

namespace Modules\Card\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Card\Entities\Card;
use Illuminate\Routing\Controller;
use Modules\Card\Services\CardService;
use Illuminate\Contracts\Support\Renderable;

class CardController extends Controller
{

    protected $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;

        $this->middleware('auth:sanctum')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $search = request('search');
        $page   = request('page');
        $search = Arr::wrap($search);

        return $this->cardService->where($search,$page);
        
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
       return $this->cardService->create($request->toArray());
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id){
        return $this->cardService->findById($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('card::edit');
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
