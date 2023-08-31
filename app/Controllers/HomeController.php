<?php

namespace App\Controllers;
use App\Models\Contact;

class HomeController extends Controller {

    public function index() {

        $contactModel = new Contact();
        return $contactModel->delete(16);
        // return $contactModel->create(['name' => 'allan', 'email' => 'allan@brito', 'phone' => '43434']);
     
        return $this->view('home', [
            'title' => 'Home',
            'description' => 'description',
        ]);

    }


}