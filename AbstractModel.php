<?php
Class AbstractModel
{
	protected $db;
	protected $id;
	protected $name;
	protected $email;

	//adapter
	public function __construct(){
		//adapter
		$this->db = new PDO("mysql:host=develepment.db.9374141.hostedresource.com;dbname=develepment", "develepment", "devLope@2");

	}
	
	//updates data
	public function save(){
		if ($this->id)
		{
		  $statement = $this->db->prepare("UPDATE contacts SET name = :name, email = :email WHERE id = :id");
		  $statement->bindParam(':id', $this->id);
		} else {
		  $statement = $this->db->prepare("INSERT INTO contacts (name, email) VALUES (:name, :email)");
		}
		$statement->bindParam(':name', $this->name);
		$statement->bindParam(':email', $this->email);
		$statement->execute();
		if (!$this->id) {
		  $this->id = $this->db->lastInsertId();
		}
	}

	//loads
	public function load($id){
		$this->id = $id;
		$statement = $this->db->prepare("SELECT id, name, email FROM contacts WHERE id = $id");
		$statement->execute(array($id));
		$data = $statement->fetch();
		$this->name = $data['name'];
		$this->email = $data['email'];
		return $this;
	}

	//deletes data
	public function delete(){
		$statement = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
		$statement->execute(array($this->id));
	}
	
	//retrieves data
	public function getData($key=false){
		if ($key){
		  return $this->$key;
		}
		return array($this->id, $this->name, $this->email);
	}
	
	//sets data
	public function setData($arr, $value=false){
		if ($value){
		  $this->$arr = $value;
		} else {
		  foreach ($arr as $k => $v) {
			$this->$k = $v;
		  }
		}
		return $this;
	}
}