<?php


namespace app\core;

use app\controllers\MoodController;

class Router {
  public $uriArray;

  public function __construct() {
    $this->uriArray = $this->routeSplit();
    $this->handleMoodRoutes();
  }

  protected function routeSplit() {
    $removeQueryParams = strtok($_SERVER["REQUEST_URI"], '?');
    return explode("/", trim($removeQueryParams, "/"));
  }

  protected function handleMoodRoutes() {
    $controller = new MoodController();

    if (($this->uriArray[0] === '' || $this->uriArray[0] === 'index') && $_SERVER['REQUEST_METHOD'] === 'GET') {
      $controller->homepage();
    }

    if ($this->uriArray[0] === 'entry' && $_SERVER['REQUEST_METHOD'] === 'GET') {
      $controller->showForm();
    }

    if ($this->uriArray[0] === 'api' && $this->uriArray[1] === 'entry' && $_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->saveEntry();
    }

    if ($this->uriArray[0] === 'entries' && $_SERVER['REQUEST_METHOD'] === 'GET') {
      $controller->getEntries();
    }

    if ($this->uriArray[0] === 'view-entries' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        include '../public/assets/views/mood/view-entries.html';
        exit();
      }

      if ($this->uriArray[0] === 'api' && $this->uriArray[1] === 'entry' && isset($this->uriArray[2]) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $id = (int) $this->uriArray[2];
        $controller = new \app\controllers\MoodController();
        $controller->deleteEntry($id);
        return;
    }
    

    if ($this->uriArray[0] === 'edit-entry' && isset($this->uriArray[1]) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = intval($this->uriArray[1]);
        $controller->entryUpdate($id);
        return;
    }
    
    if ($this->uriArray[0] === 'api' && $this->uriArray[1] === 'entry' && isset($this->uriArray[2]) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $id = (int) $this->uriArray[2];
        $controller = new \app\controllers\MoodController();
        $controller->updateEntry($id);
        return;
    }
    

    if ($this->uriArray[0] === 'api' && $this->uriArray[1] === 'entry' && isset($this->uriArray[2]) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        // Return a single entry by ID
        $controller = new MoodController();
        $controller->getEntryById((int) $this->uriArray[2]);
        return;
    }
    
    
    

}

}