<?php
namespace App\Http\Repositories;

  use App\Http\Interfaces\UserRepositoryInterface;
  use App\Models\Course;
  use App\Models\User;
  use Maatwebsite\Excel\Facades\Excel;
  use App\Exports\UsersExport;

  class UserRepository implements UserRepositoryInterface
  {
      protected $user, $course;
      public function __construct(User $user, Course $course)
      {
          $this->user = $user;
          $this->course = $course;
      }
      public function index()
    {
        $users = $this->user::select("id", "name", "email","type","birthdate","status")->get();
        return view('Pages.Users.list', compact('users'));
    }
    public function create()
    {
        $Courses = $this->course::select("id", "name")->get();
        return view('Pages.Users.create', compact('Courses'));
    }
    public function store($request)
    {
       $this->user::create([
            'name' => $request->name,
            'email' => $request->email,
            "type" => $request->type,
            'birthdate' => $request->birthdate,
            'status' => $request->status,
        ]);
        toast("user created successfully", "success");
        return to_route('users.index');
    }
    public function edit($user)
    {
        return view('Pages.Users.edit', compact('user'));
    }
    public function update($request, $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'birthdate' => $request->birthdate,
            'status' => $request->status,
        ]);
        toast("user updated successfully", "success");
        return to_route('users.index');
    }
    public function destroy($user)
    {
        $user->delete();
        toast("user deleted successfully", "success");
        return to_route('users.index');
    }
    public function changeStatus($user)
      {
          $user->update([
              'status' => $user->status === 'active' ? 'inactive' : 'active'
          ]);
          toast("User status updated successfully", "success");
          return to_route('users.index');
      }

      public function export()
      {
          return Excel::download(new UsersExport, 'users.csv');
      }
  }
