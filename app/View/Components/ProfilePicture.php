<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ProfilePicture extends Component {
    public $avatarUrl;
    public $altText;

    /**
     * Create a new component instance.
     */
    public function __construct($user = null) {
        if (! $user) {
            $this->avatarUrl = asset('images/avatars/default/user.svg');
            $this->altText = "Invité";
            return;
        }

        if ($user->is_banned) {
            $this->avatarUrl = asset('images/avatars/default/banned-user.svg');
            $this->altText = "Utilisateur banni";
        } 
        
        elseif ($user->pdp_path) {
            if (str_starts_with($user->pdp_path, 'images/')) {
                $this->avatarUrl = asset($user->pdp_path);
            } else {
                $this->avatarUrl = asset('storage/' . $user->pdp_path);
            }
            $this->altText = "Photo de profil de " . $user->name;
        } 
        
        elseif ($user->role === 'admin') { 
            $this->avatarUrl = asset('images/avatars/default/super-user.svg');
            $this->altText = "Utilisateur Administrateur";
        } 
        
        else {
            $this->avatarUrl = asset('images/avatars/default/user.svg');
            $this->altText = "Photo de profil de " . $user->name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.ui.profile-picture');
    }
}