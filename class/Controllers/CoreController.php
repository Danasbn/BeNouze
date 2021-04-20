<?php
namespace BeNouze\Controllers;

class CoreController
{

    public function show($template, $viewVars = [])
    {
        load_template($template, true, $viewVars);
    }

}
