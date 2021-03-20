<?php 
//Developer: Amitav
//Contact: amitavc65@gmail.com / 8917406257
?>
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    //Admin after login showing dashboard
    public function dashboard() {
        $layoutArr = [];
        return view('dashboard/dashboard', ['layoutArr' => $layoutArr]);
    }

}
