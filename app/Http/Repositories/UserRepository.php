<?php
namespace App\Http\Repositories;

  use App\Events\UserStatusChanged;
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
        return $this->user::select("id", "name", "email", "type", "birthdate", "status")->get();
    }
    public function create()
    {
        return $this->course::select("id", "name")->get();
    }
    public function store($request)
    {
      $user = $this->user::create([
            'name' => $request->name,
            'email' => $request->email,
            "type" => $request->type,
            'birthdate' => $request->birthdate,
            'status' => $request->status,
        ]);

        if ($request->has('courses')) {
            $user->courses()->sync($request->courses);
        }

        return $user;
    }

      public function edit($user)
      {
          $courses = $this->course::select('id', 'name')->get();
          return compact('user', 'courses');
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

          if ($request->has('courses')) {
              $user->courses()->sync($request->courses);
          }

          return $user;
      }
      public function destroy($user)
    {
        return $user->delete();
    }
    public function changeStatus($user)
      {
          $newStatus = $user->status === 'active' ? 'inactive' : 'active';
          $user->update(['status' => $newStatus]);

          event(new UserStatusChanged($user));

          return $user;

      }

      public function export()
      {
          return Excel::download(new UsersExport, 'users.csv');
      }
  }
