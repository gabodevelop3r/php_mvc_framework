<?php

namespace App\Controllers;
use App\Models\Contact;

class HomeController extends Controller {

    public function index() {

        $contactModel = new Contact();
        return $contactModel->delete( 17 );
        // return $contactModel->update(17,['name' => 'leo2', 'email' => 'leo2@brito', 'phone' => '43434']);
     
        return $this->view('home', [
            'title' => 'Home',
            'description' => 'description',
        ]);

    }


}