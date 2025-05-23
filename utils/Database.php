<?php

include_once 'logging.php';

if (!defined('DATABASE_INCLUDED')) {
    define('DATABASE_INCLUDED', true);

    class Database
    {
        private $host = DB_HOST;
        private $db_name = DB_NAME;
        private $username = DB_USER;
        private $password = DB_PASS;
        private $conn;


        public function connect()
        {
            $this->conn = null;
            debug_log("Attempting database connection");

            try {
                $this->conn = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                debug_log("Database connection successful");
            } catch (PDOException $e) {
                debug_log("Connection Error: " . $e->getMessage(), 'error');
                if (DEBUG_MODE) {
                    echo 'Connection Error: ' . $e->getMessage();
                } else {
                    echo 'Database connection error occurred. Please try again later.';
                }
            }

            return $this->conn;
        }


        public function dropTables()
        {
            debug_log("Dropping tables");
            $this->query("DROP TABLE IF EXISTS grades");
            $this->query("DROP TABLE IF EXISTS subjects");
            $this->query("DROP TABLE IF EXISTS users");
            debug_log("Tables dropped");
        }


        public function generateTables()
        {
            $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL,
            profile_picture VARCHAR(255) DEFAULT NULL,
            role ENUM('admin', 'teacher', 'student') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
            $this->query($sql);

            $sql = "CREATE TABLE IF NOT EXISTS subjects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
            $this->query($sql);

            $sql = "CREATE TABLE IF NOT EXISTS grades(
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            teacher_id INT NOT NULL,
            subject_id INT NOT NULL,
            grade INT NOT NULL CHECK (grade >= 1 AND grade <= 10),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (teacher_id) REFERENCES users(id),
            FOREIGN KEY (subject_id) REFERENCES subjects(id)    
        )";
            $this->query($sql);

            $sql = "INSERT INTO users (name, password, role, profile_picture) VALUES ('admin@admin.admin', '" . password_hash('admin@admin.admin', PASSWORD_DEFAULT) . "', 'admin', 'admin.jpg')";
            $this->query($sql);

            $sql = "INSERT INTO users (name, password, role, profile_picture) VALUES ('teacher@teacher.teacher', '" . password_hash('teacher@teacher.teacher', PASSWORD_DEFAULT) . "', 'teacher', 'teacher.png')";
            $this->query($sql);

            $sql = "INSERT INTO users (name, password, role, profile_picture) VALUES ('student@student.student', '" . password_hash('student@student.student', PASSWORD_DEFAULT) . "', 'student', 'student.jpg')";
            $this->query($sql);



            $sql = "INSERT INTO subjects (name) VALUES ('mathematics')";
            $this->query($sql);

            $sql = "INSERT INTO subjects (name) VALUES ('history')";
            $this->query($sql);

            $sql = "INSERT INTO subjects (name) VALUES ('olybet casino')";
            $this->query($sql);


            $currentYear = date('Y'); 
            $startDate = $currentYear . '-01-01 00:00:00';
            $endDate = $currentYear . '-12-31 23:59:59';
            $startTimestamp = strtotime($startDate);
            $endTimestamp = strtotime($endDate);
            



            for ($i = 1; $i <= random_int(50, 200); $i++) {
                $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
                $randomSqlDateTime = date('Y-m-d H:i:s', $randomTimestamp);
                $sql = "INSERT INTO grades (user_id, subject_id, teacher_id, grade, created_at) VALUES (" . random_int(1, 3) . ", " . random_int(1, 3) . ", " . random_int(1, 3) . ", " . random_int(1, 10) . ", '".$randomSqlDateTime."')";
                $this->query($sql);
            }

        }

        public function query($sql, $params = [])
        {
            try {
                debug_log("Executing query: {$sql}");
                if (!empty($params)) {
                    debug_log("With parameters: " . json_encode($params));
                }
                try {
                    $stmt = $this->conn->prepare($sql);
                } catch (Exception $e) {
                    debug_log("Statement preparation failed: " . $e->getMessage(), 'error');
                    throw $e;
                }

                // Bind parameters with appropriate types
                foreach ($params as $key => $value) {
                    $type = PDO::PARAM_STR;
                    if (is_int($value)) {
                        $type = PDO::PARAM_INT;
                    } elseif (is_bool($value)) {
                        $type = PDO::PARAM_BOOL;
                    } elseif (is_null($value)) {
                        $type = PDO::PARAM_NULL;
                    }
                    $stmt->bindValue($key, $value, $type);
                }
                $stmt->execute();
                debug_log("Query executed successfully");
                return $stmt;
            } catch (PDOException $e) {
                debug_log("Query Error: " . $e->getMessage(), 'error');
                throw $e;
            }
        }

        public function create($table, $data)
        {
            debug_log("Creating new record in {$table}");
            $fields = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
            $this->query($sql, $data);
            $lastId = $this->conn->lastInsertId();
            debug_log("Created record with ID: {$lastId}");
            return $lastId;
        }

        public function read($table, $conditions = [], $fields = '*')
        {
            debug_log("Reading from {$table}");
            $sql = "SELECT {$fields} FROM {$table}";
            debug_log("Executing query: {$sql}");
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $where = [];
                foreach ($conditions as $key => $value) {
                    $where[] = "{$key} = :{$key}";
                }
                $sql .= implode(' AND ', $where);
            }

            debug_log("Conditions + query: {$sql}");
            $stmt = $this->query($sql, $conditions);
            $result = $stmt->fetchAll();
            debug_log("Retrieved " . count($result) . " records");
            return $result;
        }

        public function update($table, $data, $conditions)
        {
            debug_log("Updating record(s) in {$table}");
            if (!$conditions) {
                debug_log("DANGEROUS OPERATION", 'warning');
                return false;
            }
            debug_log("Updating record(s) in {$table}");
            $set = [];
            foreach ($data as $key => $value) {
                $set[] = "{$key} = :set_{$key}";
            }

            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "{$key} = :where_{$key}";
            }

            $sql = "UPDATE {$table} SET " . implode(', ', $set) . " WHERE " . implode(' AND ', $where);

            $params = [];
            foreach ($data as $key => $value) {
                $params["set_{$key}"] = $value;
            }
            foreach ($conditions as $key => $value) {
                $params["where_{$key}"] = $value;
            }

            $result = $this->query($sql, $params);
            debug_log("Updated " . $result->rowCount() . " records");
            return $result;
        }

        public function delete($table, $conditions)
        {
            if (!$conditions) {
                debug_log("DANGEROUS OPERATION", 'warning');
                return false;
            }
            debug_log("Deleting record(s) from {$table}");
            $sql = "DELETE FROM {$table}";

            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $where = [];
                foreach ($conditions as $key => $value) {
                    $where[] = "{$key} = :{$key}";
                }
                $sql .= implode(' AND ', $where);
            }

            $result = $this->query($sql, $conditions);
            debug_log("Deleted " . $result->rowCount() . " records");
            return $result;
        }
        public function __construct()
        {
            $this->connect();
        }
    }

}