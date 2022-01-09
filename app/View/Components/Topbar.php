<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request;

class Topbar extends Component
{
    protected $params;
    protected $request;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $userInfo = $this->request->session()->get('userInfo');
        $params['userName'] = $userInfo['nome'];
        $params['avatarPath'] = "assets/img/avatars/" . ($userInfo['avatar'] ?? "undraw_profile.svg");
        $params['profileUrl'] = "route('/users/{$userInfo['id']}')";
        $params['logoffUrl'] = "route('/logoff')";
        return view('components.topbar', ['params' => $params]);
    }
}
