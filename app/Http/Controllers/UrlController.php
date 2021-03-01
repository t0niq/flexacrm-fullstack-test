<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Repositories\Interfaces\UrlRepositoryInterface;
use App\Services\UrlShortener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UrlController extends Controller
{
    private $urlRepository;
    private $urlShortener;

    public function __construct(UrlRepositoryInterface $urlRepository, UrlShortener $urlShortener)
    {
        $this->urlRepository = $urlRepository;
        $this->urlShortener = $urlShortener;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        //TODO: add pagination
        $urls = $this->urlRepository->findForUser(Auth::user());
        return Inertia::render('Urls/index', ['data' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'title' => 'required',
            'url' => 'required|url',
            'short_url' => 'unique:urls,short_url'
        ]);

        if($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            return response()->json($errors, 422);
        }

        $this->urlRepository->store($validator->validated());

        return redirect()->back()->with('message', 'Url Created Successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required|url'
        ]);

        $this->urlRepository->update($validator->validated(), Url::find($id));
        return redirect()->back()->with('message', 'Url Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Url::find($id)->delete();
        return redirect()->back()->with('message', 'Url Deleted Successfully.');
    }
}
