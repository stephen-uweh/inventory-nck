<?php
namespace App\Classes;

use App\Http\Resources\UserResource;
use App\Mail\RegistrationEmail;
use App\Models\Cart;
use App\Notifications\SuccessfulRegistration;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AuthenticationManagement {
    private $auth;
//sdkdj
    private $userRepository;

    public function __construct
    (
        UserRepositoryInterface $userRepository
    ) {
        $this->auth = Auth();
        $this->userRepository = $userRepository;
    }

    public function login(array $data) {

        $user = null;
        DB::transaction(function () use ($data, &$user) {
            $token = $this->auth->attempt($data);;
            if (!$token) {
                throw new AuthenticationException("Incorrect credentials");
            }
            $user = $this->userRepository->getById($this->auth->user()->id);
            $user->access_token = $token;
            $user = new UserResource($user);
        });
        return $user;
    }

    public function register(array $data) {

        $user = null;
        $password = $data['password'];
        $data['password'] = Hash::make($password);
        DB::transaction(function () use (&$user,$data) {
            $user = $this->userRepository->create($data);
            $user = new UserResource($user);
        });
        Cart::create([
            'user_id' => $user['id'],
            'active' => true
        ]);
        return $user;
    }
}
