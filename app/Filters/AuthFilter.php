<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = (int) session('user_id');
        $user = $userId ? (new UserModel())->where('id', $userId)->where('is_active', 1)->first() : null;

        if (! $user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Please sign in to continue.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No response changes are required after authenticated requests.
    }
}
