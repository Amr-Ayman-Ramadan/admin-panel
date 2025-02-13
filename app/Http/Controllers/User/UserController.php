<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Requests\User\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    protected $UserRepositoryInterface;

    public function __construct(UserRepositoryInterface $UserRepositoryInterface)
    {
        $this->UserRepositoryInterface = $UserRepositoryInterface;
    }
    public function index()
    {
       return $this->UserRepositoryInterface->index();
    }
    public function create()
    {
        return $this->UserRepositoryInterface->create();
    }
    public function store(UserRequest $request)
    {
        return $this->UserRepositoryInterface->store($request);
    }
    public function edit(User $user)
    {
        return $this->UserRepositoryInterface->edit($user);
    }
    public function update(UserRequest $request, User $user)
    {
        return $this->UserRepositoryInterface->update($request, $user);
    }
    public function destroy(User $user)
    {
        return $this->UserRepositoryInterface->destroy($user);
    }
    public function changeStatus(User $user)
    {
        return $this->UserRepositoryInterface->changeStatus($user);
    }

    public function export()
    {
        $this->UserRepositoryInterface->export();
    }

}
