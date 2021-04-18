<?php 
    class User {
        private $db;
        private $table = "users";

        public function __construct()
        {
            $this->db = new Database;
        }

        public function getUsers()
        {
            $this->db->query('SELECT * FROM '.$this->table.'');
            $results = $this->db->resultSet();
            return $results;
        }
    }