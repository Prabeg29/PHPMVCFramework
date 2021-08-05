<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Request;
use app\Core\Response;
use app\Core\Application;
use app\Models\ContactForm;

class SiteController extends Controller{
    public function home() {
        $params = [
            "name" => "Paranoid Android"
        ];
        return $this->render('home', $params);
    }

    public function contact(Request $request, Response $response) {
        $contactForm = new ContactForm;
        if($request->isPost()){
            $contactForm->loadData($request->getBody());
            if($contactForm->validate() && $contactForm->send){
                Application::$app->session->setFlashMessage('Success', 'Thank you for contacting us');
                Application::$app->session->getFlashMessage('Success');
                $response->redirect('/');
            }
        }
        return $this->render('contact', [
            "model" => $contactForm
        ]);
    }
}