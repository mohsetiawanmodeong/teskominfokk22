<?php

// error_reporting(0);

class Db
{
    private $dbsetup;
    private $conn;
    private $sql;

    public function __construct($dbsetup)
    {
        $this->dbsetup = $dbsetup;
        // $this->conn = false;
    }

    public function db()
    {
        $dbsetup = $this->dbsetup;
        if ($this->conn) return $this;
        try {
            // $this->conn = new PDO("mysql:host=localhost;dbname=senggol", "root", "");
            // $db = new PDO("mysql:host=localhost;dbname=senggol", "root", "");
            //die(print_r($dbsetup));
            $this->conn = new PDO("mysql:host=" . $dbsetup['host'] . ";dbname=" . $dbsetup['name'] . "", $dbsetup['user'], $dbsetup['pass']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successful" . PHP_EOL . "";
            // echo "Data Pendaftaran Pasar Senggol: " . PHP_EOL . "";
            // $sql = "SELECT * FROM pendaftar";
            // $pendaftar = $this->conn->query($sql);
            // foreach ($pendaftar as $daftar) {
            //     echo "Id: " . $daftar["idpendaftar"] . "" . PHP_EOL . "";
            //     echo "Tahun: " . $daftar["tahun"] . "" . PHP_EOL . "";
            //     echo "Bulan: " . $daftar["bulan"] . "" . PHP_EOL . "";
            //     echo "NIK: " . $daftar["nik"] . "" . PHP_EOL . "";
            //     echo "Nama: " . $daftar["nama"] . "" . PHP_EOL . "";
            //     echo "Alamat: " . $daftar["alamat"] . "" . PHP_EOL . "";
            //     echo "Surel: " . $daftar["surel"] . "";
            // }
            return $this;
        } catch (PDOException $e) {
            die("Connection failed : " . $e->getMessage());
        }
    }

    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function countRegistration($data)
    {
        $sql = "SELECT COUNT(*) c FROM pendaftar WHERE nik=?";
        // var_dump($this->conn);
        $this->sql = $this->conn->prepare($sql);
        $this->sql->bindValue(1, $data['nik'] ?? 0);
        return $this;
    }

    public function addRegistration($data)
    {
        $sql = "INSERT INTO pendaftar(tahun, bulan, nik, nama, alamat, surel) VALUES(?, ?, ?, ?, ?, ?)";
        $sql = $this->conn->prepare($sql);
        $sql->bindValue(1, @$data['tahun']);
        $sql->bindValue(2, @$data['bulan']);
        $sql->bindValue(3, @$data['nik']);
        $sql->bindValue(4, @$data['nama']);
        $sql->bindValue(5, @$data['alamat']);
        $sql->bindValue(6, @$data['surel']);
        $sql->execute();
        return true;
    }

    public function st()
    {
        $this->sql->execute();
        return $this;
    }

    public function fetchColumn()
    {
        return $this->sql->fetchColumn();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollBack()
    {
        return $this->sql->rollBack();
    }
}
