<?php

namespace BeNouze\Controllers;

use BeNouze\Models\Consult;
use BeNouze\Models\Reviews;

class TestController extends CoreController
{

    public function sandbox()
    {
         echo '<div style="border: solid 2px #F00">';
             echo '<div style="; background-color:#CCC">@'.__FILE__.' : '.__LINE__.'</div>';
             echo '<pre style="background-color: rgba(255,255,255, 0.8);">';
             print_r('sandbox page');
             echo '</pre>';
         echo '</div>';

         //$testModel = new Consult();
         //$testModel->createTable();
         
        //$testModel->createTable();
        // $experienceModel = new Experience();
        // $experienceModel->createFixtures();
        // $experienceModel->delete(23);
        // $experienceModel::update(24, [
        //     'title' => "Hop mise à jour"
        // ]);
        // $experiences = $experienceModel::findAll();
        // $autreExperience = new Experience();
        // $autreExperience->loadById(24);
        /*
        $experienceModel->delete(1);
        $experienceModel->delete('0 OR id > 0');
        */
    }
}
