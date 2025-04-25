<?php

namespace app\controllers;

use app\models\Journal;

class MoodController {

  public function showForm() {
    include '../public/assets/views/mood/entry.html';
    exit();
  }

  public function saveEntry() {
    $data = json_decode(file_get_contents("php://input"), true);

    $mood = $data['mood'] ?? null;
    $entry = $data['entry'] ?? null;

    if (!$mood || !$entry) {
      http_response_code(400);
      echo json_encode(['error' => 'Both mood and entry are required.']);
      return;
    }

    $journal = new Journal();
    $success = $journal->insert($mood, $entry);

    if ($success) {
      http_response_code(200);
      echo json_encode(['success' => true]);
    } else {
      http_response_code(500);
      echo json_encode(['error' => 'Failed to save entry.']);
    }
  }

  public function homepage() {
    include '../public/assets/views/main/homepage.html';
    exit();
  }

  public function getEntries() {
    $journal = new Journal();
    $entries = $journal->findAll();
    header('Content-Type: application/json');
    echo json_encode($entries);
    exit();
  }

  public function updateEntry($id) {
    header('Content-Type: application/json');

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing ID']);
        exit();
    }

    parse_str(file_get_contents('php://input'), $_PUT);

    $mood = $_PUT['mood'] ?? null;
    $entry = $_PUT['entry'] ?? null;

    if (!$mood || !$entry) {
        http_response_code(400);
        echo json_encode(['error' => 'Mood and entry are required']);
        exit();
    }

    $journal = new \app\models\Journal();
    $success = $journal->updateEntry([
        'id' => $id,
        'mood' => htmlspecialchars($mood),
        'entry' => htmlspecialchars($entry)
    ]);

    if ($success) {
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update entry']);
    }

    exit();
}


public function deleteEntry($id) {
    if (!$id) {
        http_response_code(404);
        exit();
    }

    $journal = new Journal();
    $result = $journal->deleteEntry([
        'id' => $id,
    ]);

    http_response_code(200);
    echo json_encode([
        'success' => true
    ]);
    exit();
}

public function entryAdd() {
    include '../public/assets/views/mood/entry.html';
    exit();
}

public function entryDelete() {
    include '../public/assets/views/mood/delete-entry.html';
    exit();
}

public function entryUpdate($id) {
    include '../public/assets/views/mood/edit-entry.html';
    exit();
}


public function getEntryById($id) {
    $journal = new Journal();
    $entry = $journal->findById($id);
    if ($entry) {
        header('Content-Type: application/json');
        echo json_encode($entry);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Entry not found.']);
    }
    exit();
}


}


/*namespace app\controllers;

use app\models\Journal;

class MoodController
{
    public function getEntries() {
        $journalModel = new Journal();
        $query = !empty($_GET['mood']) ? $_GET['mood'] : null;
        $entries = $journalModel->findAll();
        echo json_encode($entries);
        exit();
    }

    public function getEntryByID($id) {
        $journalModel = new Journal();
        $entry = $journalModel->findById($id);
        echo json_encode($entry);
        exit();
    }

    public function entriesView() {
        include '../public/assets/views/main/homepage.html';
        exit();
    }

    public function showMoodPrompt() {
        include '../public/assets/views/mood/entry.html';
        exit();
    }

    public function saveEntry() {
        // Decode JSON input
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Optional: Log incoming data for debugging
        file_put_contents("debug_log.txt", print_r($data, true));
    
        // Safely extract mood and entry
        $mood = $data['mood'] ?? null;
        $entry = $data['entry'] ?? null;
    
        // Validate input
        $entryData = $this->validateEntry([
            'mood' => $mood,
            'entry' => $entry,
        ]);
    
        // Insert into database
        $journal = new Journal();
        $success = $journal->insert($entryData['mood'], $entryData['entry']);
    
        // Respond to client
        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Entry saved']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save entry to database']);
        }
    
        exit();
    }
    
    

    public function updateEntry($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'mood' => $_PUT['mood'] ?? null,
            'entry' => $_PUT['entry'] ?? null,
        ];

        $entryData = $this->validateEntry($inputData);

        $journal = new Journal();
        $journal->updateEntry([
            'id' => $id,
            'mood' => $_PUT['mood'],
            'entry' => $entryData['entry'],
        ]);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function deleteEntry($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $journal = new Journal();
        $journal->deleteEntry(['id' => $id]);

        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    private function validateEntry($input) {
        $errors = [];

        $mood = $inputData['mood'] ?? null;
        $entry = $inputData['entry'] ?? null;

        if (!$mood) {
            $errors['moodRequired'] = 'Mood is required.';
        }

        if ($entry) {
            $entry = htmlspecialchars($entry, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if (strlen($entry) < 2) {
                $errors['entryShort'] = 'Entry must be at least 2 characters.';
            }
        } else {
            $errors['entryRequired'] = 'Entry is required.';
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        return [
            'mood' => $mood,
            'entry' => $entry
        ];
    }

    public function entryAdd() {
        include '../public/assets/views/mood/entry.html';
        exit();
    }

    public function entryDelete() {
        include '../public/assets/views/mood/entry-delete.html';
        exit();
    }
}*/