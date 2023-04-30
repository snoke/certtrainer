<?php
/*
 * Author: Stefan Sander <mail@stefan-sander.online>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpKernel\KernelInterface;

class AppController extends AbstractController
{
    private KernelInterface $kernel;
    private array $questions;
    private bool $shuffleQuestions = true;
    private bool $shuffleCategories = true;

    private function parseData($data) {
        $this->questions[$data->name] = Yaml::parse($data->content);
        if ($this->shuffleQuestions) {
            shuffle($this->questions[$data->name]["questions"]);
        }
    }
    
    private function loadDataFiles($fileExtension='.yml') {
        foreach(scandir($this->dataPath) as $file) {
            $ymlPosition = strpos($file,$fileExtension);
            if ($ymlPosition && 4===(strlen($file)-$ymlPosition)) {
                yield (object)[
                    'name' => substr($file,0,strlen($fileExtension)*-1), 
                    'content' => file_get_contents($this->dataPath.'/'.$file)
                ];
            }
        }
    }

    public function __construct(KernelInterface $kernel) {
        $this->dataPath = $kernel->getProjectDir() . '/data';
        foreach($this->loadDataFiles() as $data) {
            $this->parseData($data);
        }
        if ($this->shuffleCategories) {
            shuffle($this->questions);
        }
    }

    /**
     * @Route("/", name="index")
     * @Route("/{route}", name="index_route", requirements={"route"="^.+"})
     */
    public function index(): Response
    {   
        return $this->render('vue.html.twig', [
            'controller_name' => 'AppController',
            'questions' => json_encode($this->questions)
        ]);
    }
}