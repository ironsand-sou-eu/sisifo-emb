<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

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
        $params['userName'] = Auth::user()->nome_escolhido;
        $params['avatarPath'] = '/assets/img/avatars/'.(Auth::user()->avatar_path ?? 'undraw_profile.svg');
        $params['profileUrl'] = route('myProfile');
        $params['logoffUrl'] = route('logout');

        return view('components.topbar', ['params' => $params]);
    }
}
