<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Requests\User\UserRequest;
use App\Models\Course;
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
        $users = $this->UserRepositoryInterface->index();
        return view('Pages.Users.list', compact('users'));    }
    public function create()
    {
        $courses = $this->UserRepositoryInterface->create();
        return view('Pages.Users.create', compact('courses'));
    }
    public function store(UserRequest $request)
    {
        $this->UserRepositoryInterface->store($request);
        toast("user created successfully", "success");
        return to_route('users.index');
    }
    public function edit(User $user)
    {
        $data = $this->UserRepositoryInterface->edit($user);
        return view('Pages.Users.edit', $data);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->UserRepositoryInterface->update($request, $user);
        toast("user updated successfully", "success");
        return to_route('users.index');
    }
    public function destroy(User $user)
    {
        $this->UserRepositoryInterface->destroy($user);
        toast("user deleted successfully", "success");
        return to_route('users.index');    }
    public function changeStatus(User $user)
    {
        $this->UserRepositoryInterface->changeStatus($user);
        toast("User status updated successfully", "success");
        return to_route('users.index');
    }

    public function export()
    {
        return $this->UserRepositoryInterface->export();
    }
}
