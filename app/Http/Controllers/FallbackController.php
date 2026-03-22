<?php

namespace App\Http\Controllers;

class FallbackController extends Controller
{
    public function login()
    {
        return redirect()->route('auth.login');
    }

    public function admin()
    {
        return redirect('/' . app()->getLocale() . '/admin');
    }

    public function dashboard($any = null)
    {
        return redirect('/' . app()->getLocale() . '/admin' . ($any ? '/' . $any : ''));
    }

    public function home()
    {
        return redirect('/' . app()->getLocale());
    }

    public function catchAll($path)
    {
        return redirect('/' . app()->getLocale() . '/' . $path);
    }
}
