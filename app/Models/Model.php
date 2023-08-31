<?php

namespace App\Models;
use mysqli;

class Model {
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $table;
    protected $query;

    public function __construct() {
        $this->connection();
    }


    public function connection(){

        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if( $this->connection->connect_error )
            die('Error de connexion: '.$this->connection->error);

    }

    public function query( string $sql, $data = [], $params = null ){

        if( $data ):
            if( !$params )
                $params = str_repeat('s', count( $data ) );   
            $stmt = $this->connection->prepare( $sql );
            $stmt->bind_param( $params, ...$data );
            $stmt->execute( );
            $this->query = $stmt->get_result();
        else:
            $this->query = $this->connection->query( $sql );
        endif;
        
        return $this;
    }

    public function first(){
        return $this->query->fetch_assoc();
    }

    public function get() : array
    {
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }
    // consultas
    public function all() : array
    {
        $sql = "SELECT * FROM $this->table";
        return $this->query($sql)->get();
    }

    public function find( int $id ){
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        return $this->query($sql, [$id], 'i')->first();
    }

    public function where(string $column, string $operator, $value = null ) : self
    {

        if( !$value ):
            $value = $operator;
            $operator = '=';
        endif;

        $value = $this->connection->real_escape_string($value);

        $sql = "SELECT * FROM $this->table WHERE $column $operator ?";

        $this->query( $sql, [$value], 's' );

        return $this;
    }

    public function create( array $data ) : array
    {

        $colums = implode(',',array_keys( $data ) ); # transformar array en una cadena
        $values = array_values( $data );
        $sql = "INSERT INTO $this->table ($colums)  VALUES (".str_repeat('?, ', count( $values ) - 1 )."?)";
        $this->query( $sql, $values, str_repeat('s', count( $values ) ) );
        return $this->find($this->connection->insert_id);

    }

    public function update( int $id, array $data )  : array
    {
        $fields = array();
        
        foreach( $data as $key => $value)
            array_push( $fields, "$key = ?" );
        
        $fields = implode(', ', $fields);
        $sql = "UPDATE $this->table SET $fields WHERE id = ?";
        $values = array_values( $data ); 
        $values[] = $id; 
        $this->query( $sql, $values, str_repeat('s', count( $values ) ) );

        return $this->find( $id );
    }

    public function delete( int $id ) : void
    {

        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->query( $sql, [ $id ] , 'i' );
    }
}