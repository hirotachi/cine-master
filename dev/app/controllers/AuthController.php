<?php

namespace App\Controllers;


use App\Core\Request;
use App\Middleware\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController
{
    protected User $userModel;

    /**
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }


    public function login(Request $req): RedirectResponse|string
    {
        $data = $req->getBody();
        $requiredKeys = ["password", "username"];
        $required = verifyArrayKeys($requiredKeys, $data);
        if ($required) {
            return view("auth",
                ["errorFields" => $required, "message" => "please enter required input", "page" => "login"]);
        }
        $user = $this->userModel->fetchOne("username = :username or email = :username", $data);
        if (!$user || !password_verify($data["password"], $user->password)) {
            return view("auth",
                ["page" => "login", "errorFields" => $requiredKeys, "message" => "Username or password is wrong"]);
        }
        Auth::login((array) $user);
        return redirect()->route("home");
    }

    public function register(Request $req): string
    {
        $data = $req->getBody();
        $required = $this->userModel->verifyRequired($data);
        if ($required) {
            return view("auth",
                ["errorFields" => $required, "message" => "please fill the required fields", "page" => "register"]);
        }
        $data["password"] = password_hash($data["password"], PASSWORD_ARGON2I);
        $id = $this->userModel->create($data);
        Auth::login(["îd" => $id]);
        return redirect()->route("home");
    }

    public function logout(Request $req): RedirectResponse
    {
        $referer = $req->headers->get("referer");
        Auth::logout();
        return redirect($referer);
    }
}