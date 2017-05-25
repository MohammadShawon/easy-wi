<?php

namespace App\Http\Controllers\Api\V1\GlobalAdmin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\ApiController;

class AdminController extends ApiController
{

    /**
     * Validation configuration, for an admin entry.
     *
     * @var array
     */
    public $validationRules = [
        'name' => 'required|string|max:255',
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => 'required|email|unique:admins|max:255',
        'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'locked' => 'boolean'
    ];

    /**
     * Base url used by this controller.
     *
     * @var string
     */
    protected $baseUrl = '/api/v1/global/admins/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Admin::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Admin $admin)
    {
        return $this->createEntry($admin, $request->only('name', 'first_name', 'last_name', 'email', 'password', 'locked'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin, $id)
    {
        return $admin->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin, $id)
    {
        // Do not use the password validator for updates
        unset($this->validationRules['password']);

        // email filter needs to be altered, so that the current email does not cause a false positive
        $this->validationRules['email'] = 'required|email|max:255|unique:admins,id,' . $id;

        // Search for the entry or fail. Also pass the filtered request
        return $this->updateEntry($admin, $id, $request->only('name', 'first_name', 'last_name', 'email', 'locked'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Admin $admin
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin, $id)
    {
        return $this->deleteEntry($admin, $id);
    }

    /**
     * Update an admins password.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin $admin
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request, Admin $admin, $id)
    {
        // Only the password needs to be validated
        $this->validationRules = [
            'password' => $this->validationRules['password']
        ];

        // Search for the entry or fail. Also pass the filtered request
        return $this->updateEntry($admin, $id, $request->only('password'));
    }
}
