<?php

namespace app\models;

class Journal extends Model {
  protected string $table = 'journal';

  public function insert($mood, $entry) {
    $query = "INSERT INTO journal (mood, entry) VALUES (:mood, :entry)";
    return $this->query($query, [
      'mood' => $mood,
      'entry' => $entry
    ]);
  }

  public function findAll() {
    return $this->query("SELECT * FROM journal ORDER BY date DESC");
  }

  public function updateEntry($data) {
    $query = "UPDATE journal SET mood = :mood, entry = :entry WHERE id = :id";
    return $this->query($query, $data);
}


public function deleteEntry($data) {
    $query = "DELETE FROM journal WHERE id = :id";
    return $this->query($query, $data);
}

public function findById($id) {
    $query = "SELECT * FROM {$this->table} WHERE id = :id";
    $result = $this->query($query, ['id' => $id]);
    return $result[0] ?? null;
}


} 
