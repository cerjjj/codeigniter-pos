<?php

namespace App\Controllers;

use App\Controllers\Concerns\HandlesImages;
use App\Models\UserModel;

class Staff extends BaseController
{
    use HandlesImages;

    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function index(): string
    {
        return view('staff/index', ['title' => 'Staff', 'staff' => $this->users->orderBy('is_active', 'DESC')->orderBy('full_name')->findAll()]);
    }

    public function new(): string
    {
        return view('staff/form', ['title' => 'Add staff member', 'member' => null]);
    }

    public function create()
    {
        return $this->persist();
    }

    public function edit(int $id)
    {
        $member = $this->users->find($id);
        return $member
            ? view('staff/form', ['title' => 'Edit staff member', 'member' => $member])
            : redirect()->to('/staff')->with('error', 'Staff member not found.');
    }

    public function update(int $id)
    {
        return $this->users->find($id)
            ? $this->persist($id)
            : redirect()->to('/staff')->with('error', 'Staff member not found.');
    }

    public function archive(int $id)
    {
        if ($id === (int) session('user_id')) {
            return redirect()->to('/staff')->with('error', 'You cannot archive your own account.');
        }

        $member = $this->users->find($id);
        if (! $member) {
            return redirect()->to('/staff')->with('error', 'Staff member not found.');
        }

        $active = (int) ! (bool) $member['is_active'];
        $this->users->update($id, ['is_active' => $active]);
        return redirect()->to('/staff')->with('success', $active ? 'Staff account restored.' : 'Staff account archived.');
    }

    private function persist(?int $id = null)
    {
        $usernameRule = $id ? "is_unique[users.username,id,{$id}]" : 'is_unique[users.username]';
        $passwordRules = $id ? 'permit_empty|min_length[8]|max_length[255]' : 'required|min_length[8]|max_length[255]';
        $rules = [
            'username' => "required|alpha_numeric_punct|min_length[3]|max_length[50]|{$usernameRule}",
            'full_name' => 'required|max_length[100]',
            'password' => $passwordRules,
        ];

        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'is_active' => $this->request->getPost('is_active') === null ? 1 : (int) (bool) $this->request->getPost('is_active'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $data['avatar'] = $this->storeImage($avatar, 'avatars', 480, 480);
        }

        $id ? $this->users->update($id, $data) : $this->users->insert($data);
        return redirect()->to('/staff')->with('success', $id ? 'Staff member updated.' : 'Staff member added.');
    }
}
