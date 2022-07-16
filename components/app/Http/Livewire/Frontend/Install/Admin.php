<?php

namespace App\Http\Livewire\Frontend\Install;

use Livewire\Component;
use App\Models\Admin\User;
use DateTime;
use Brotzka\DotenvEditor\DotenvEditor;
use App\Models\Install;
class Admin extends Component
{
    public $email;
    public $password;

    public function mount(){
        $install                  = Install::findOrFail(1);
        if ($install->database    == false) return redirect()->route('sw_database');
    }

    public function render()
    {
        return view('livewire.frontend.install.admin');
    }

    public function onCreateAdmin(){

        $this->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ( User::find(1) === null ) {

            $user                    = new User;
            $user->id                = 1;
            $user->fullname          = 'MidHunter';
            $user->position          = 'CEO / Co-Founder';
            $user->address           = 'Ciamis, Sindangkasih 46268 Jawabarat';
            $user->phone             = '+6282127526055';
            $user->email             = $this->email;
            $user->password          = bcrypt($this->password);
            $user->bio               = 'Nikmati hal kecil di hidup. Untuk suatu hari, Anda mungkin melihat ke belakang dan menyadari bahwa itu adalah hal-hal besar. Banyak dari kegagalan hidup adalah orang-orang yang tidak menyadari betapa dekatnya mereka dengan kesuksesan ketika mereka menyerah.';
            $user->gender            = 1;
            $user->avatar            = asset('assets/img/avatar.jpg');
            $user->social_status     = true;
            $user->is_admin          = true;
            $user->email_verified_at = new DateTime();
            $user->created_at        = new DateTime();
            $user->save();

            $install        = Install::findOrFail(1);
            $install->admin = true;
            $install->save();

            return redirect()->route('sw_import');

        }
        else {

            $user             = User::findOrFail(1);
            $user->email      = $this->email;
            $user->password   = bcrypt($this->password);
            $user->updated_at = new DateTime();
            $user->save();

            $install        = Install::findOrFail(1);
            $install->admin = true;
            $install->save();

            return redirect()->route('sw_import');
        }

    }
}
