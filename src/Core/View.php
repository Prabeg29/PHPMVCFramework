<?php

namespace app\Core;

class View {
    public string $title = '';

    public function view($view, $params = []){
        $viewContent =  $this->viewContent($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent() {
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$SRC."/Views/Layouts/$layout.php";
        return ob_get_clean();
    }

    public function viewContent($view, $params) {
        foreach($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$SRC."/Views/$view.php";
        return ob_get_clean();
    }
}