<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;

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
        $params['avatarPath'] = '/assets/img/avatars/'.($userInfo['avatar'] ?? 'undraw_profile.svg');
        $params['profileUrl'] = route('myProfile');
        $params['logoffUrl'] = route('logout');

        return view('components.topbar', ['params' => $params]);
    }
}
