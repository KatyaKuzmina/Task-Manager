<?php

require_once __DIR__ . '/../Core/Database.php';

class Task
{
	protected $pdo;

	public function __construct()
	{
		$this->pdo = Database::connect();
	}

	public function getAllByUserId($userId)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
		$stmt->execute([$userId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update($id, $name, $tag, $description, $dateStart, $dateTill, $color)
	{
		$stmt = $this->pdo->prepare("
            UPDATE tasks 
            SET name = ?, tag = ?, description = ?, date_started = ?, date_till = ?, color = ? 
            WHERE id = ?
        ");

		return $stmt->execute([$name, $tag, $description, $dateStart, $dateTill, $color, $id]);
	}

	public function updateProgress($id, $progress)
	{
		$stmt = $this->pdo->prepare("UPDATE tasks SET progress = ? WHERE id = ?");
		return $stmt->execute([$progress, $id]);
	}

	public function create($userId, $name, $tag, $description, $dateStart, $dateTill, $color, $progress)
	{
		$stmt = $this->pdo->prepare("
        INSERT INTO tasks (user_id, name, tag, description, date_started, date_till, color, progress)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

		return $stmt->execute([$userId, $name, $tag, $description, $dateStart, $dateTill, $color, $progress]);
	}

	public function delete($id)
	{
		$stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");

		if ($stmt->execute([$id])) {
			return true;
		} else {
			print_r($stmt->errorInfo());
			return false;
		}
	}
}
