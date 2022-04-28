<?php

// error_reporting(0);

class Db
{
    // private $dbSetup;
    private $conn;
    private $sql;

    // public function __construct($param)
    // {
    //     $this->dbSetup = $param;
    // }

    public function db($dbsetup)
    {
        try {
            // $this->conn = new PDO("mysql:host=localhost;dbname=senggol", "root", "");
            $this->conn = new PDO("mysql:host=" . $dbsetup['host'] . ";dbname=" . $dbsetup['name'] . "", $dbsetup['user'], $dbsetup['pass']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection successful" . PHP_EOL . "";
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
        } catch (PDOException $e) {
            die("Connection failed : " . $e->getMessage());
        }
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function countRegisteration($data)
    {
        $id = $data['idpendaftar'];
        $sql = $this->conn->prepare("SELECT COUNT(*) FROM pendaftar WHERE idpendaftar=?");
        $sql->bindValue(1, $id);

        $this->sql = $sql;
    }

    public function st()
    {
        $this->sql->execute();
    }

    public function fetchColumn()
    {
        return $this->sql->fetchColumn();
    }

    public function addRegistration($data)
    {
        $sql = "INSERT INTO pendaftar(nik, nama, alamat, surel) VALUES(:nik, :nama, :alamat, :surel)";
        $sql = $this->conn->prepare($data);
        $sql->execute($sql);
        return true;
    }

    public function lastInsertId()
    {
        return $this->sql->lastInsertId();
    }

    public function rollBack()
    {
        return $this->sql->rollBack();
    }

    public function commit()
    {
        return $this->sql->commit();
    }
}
