<?php
namespace App\Http\Interfaces;

interface UserRepositoryInterface
{
    public function index();
    public function create();
    public function store($request);

    public function edit($user);

    public function update($request, $user);

    public function destroy($user);

    public function changeStatus($user);

    public function export();
}
