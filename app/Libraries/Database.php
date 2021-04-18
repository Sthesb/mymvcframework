<?php
    class Database {
        private $dbHost = DB_HOST;
        private $dbName = DB_NAME;
        private $dbUser = DB_USER;
        private $dbPass = DB_PASS;

        private $statement, $handler, $error;

        public function __construct()
        {
            $conn = 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try
            {
                $this->handler = new PDO ($conn, $this->dbUser, $this->dbPass, $options );

            }
            catch(PDOException $e)
            {
                $this->error = $e;
                echo 'No connection : '.$this->error->getMessage();
            }
        }


        // Method that allows to write queries
        public function query($sql)
        {
            $this->statement = $this->handler->prepare($sql);
        }
        // bind values
        public function bind($parameters, $value, $type = null)
        {
            switch(is_null($type)){
                case is_int($value) : 
                    $type = PDO::PARAM_INT;
                    break;
                case is_null($value) : 
                    $type = PDO::PARAM_NULL;
                    break;
                
                case is_bool($value) : 
                    $type = PDO::PARAM_BOOL;
                    break;

                default : 
                    $type = PDO::PARAM_STR;
            }

            $this->statement->bind($parameters, $value, $type);
        }

        // Execute the prepared statement 
        public function execute(){
            return $this->statement->execute();
        }

        // Return an array
        public function resultSet(){
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }
        // Return single row
        public function single(){
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }
        // get row count
        public function rowCount(){
            return $this->statement->rowCount();
        }
    }