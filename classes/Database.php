<?php

class Database
{

    private static $INSTANCE = null;
    private $mysqli,    

    $HOST = "172.17.0.2",
    $USER = "root",
    $PASS = "salupa",
    $DATABASE = "web_vpp",
    $PORT = "3306";

    public function __construct()
    {

        // Melakukan koneksi ke Database
        $this->mysqli = new mysqli($this->HOST, $this->USER, $this->PASS, $this->DATABASE, $this->PORT);

        // Jika connection ke Database error, baris berikut akan dieksekusi.
        if (mysqli_connect_error()) {
            Session::flash("Gagal koneksi ke database");
        }

    }

    // Singleton pattern, Menguji koneksi agar tidak double
    public static function getInstance()
    {
        if (!isset(self::$INSTANCE)) {
            self::$INSTANCE = new Database();
        }

        return self::$INSTANCE;
    }

    // Fungsi untuk melakukan query ke database
    public function run_query($query, $message)
    {
        if ($this->mysqli->query($query))
            // Jika query yang dilakukan benar
            return true;
        else
            // Jika query yang dilakukan salah
            echo($message);
    }

    // Fungsi untuk memisahkan karakter sql, untuk mengamankan Query SQL Injection
    public function escape($name)
    {
        return $this->mysqli->real_escape_string(stripslashes(htmlspecialchars($name)));
    }



    // Fungsi untuk menampilkan data berdasarkan $table, $column, $value, dan $role
    public function get_info($fields, $table = ' ', $column = ' ', $value = ' ')
    {
        // Jika $value tidak bertipe int, maka akan ditambahkan '' (petik dua)
        if (!is_int($value)) {
            $value = "'" . $value . "'";
        }

        // Jika $column pada fungsi diisi saat fungsi dipanggil, maka kondisi akan dijalankan.
        if ($column != '') {

            // Get Values
            $valueArrays = array();
            $i = 0;
            foreach ($fields as $key => $values) {
                $valueArrays[$i] = $key;
                $i++;
            }
            $row = implode(", ", $valueArrays);          

            // Memilih semua data column yang memiliki value secara dinamis
            $query = "SELECT $row FROM $table WHERE $column = $value";

            $result = $this->mysqli->query($query);

            // Menampilkan data dalam tipe array_associatipe
            while ($row = $result->fetch_assoc()) {
                return $row;
            }

            
        }

        // Jika tidak ada parameter pada fungsi saat fungsi dipanggil, maka kondisi akan dijalankan.
        else {          

            // Get Values
            $valueArrays = array();
            $i = 0;
            foreach ($fields as $key => $values) {
                $valueArrays[$i] = $key;
                $i++;
            }
            $row = implode(", ", $valueArrays);   
            
            $query = "SELECT $row FROM user LEFT JOIN batch USING(batch_id) JOIN role USING(role_id) GROUP BY user.date_created DESC";
                
            // query untuk pagination : SELECT * FROM user LEFT JOIN batch USING(batch_id) JOIN role USING(role_id) ORDER BY user.user_id DESC LIMIT 1, 8;
            $result = $this->mysqli->query($query);

            // Menampilkan data dalam tipe array_associatipe
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            return $results;

        }

    }

}