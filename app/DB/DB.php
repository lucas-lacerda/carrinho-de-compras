<?php

namespace App\DB;
use PDO;

class DB extends PDO
{
    public $db;

    public function __construct($sgdb, $host, $db, $user, $password, $persistent=true)
    {
        $options = [
            PDO::ATTR_PERSISTENT => $persistent,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $dns = sprintf('%s:host=%s;dbname=%s;charset=utf8', $sgdb, $host, $db);
        parent::__construct($dns, $user, $password, $options);
    }
    
    protected function bindValues(&$sth, $data = [])
    {
        foreach ($data as $key => $val) {
            $tipo = (is_int($val))? PDO::PARAM_INT: PDO::PARAM_STR;
            $sth->bindValue(":$key", $val, $tipo);
        }
    }
    
    public function select($sql, array $where = [], $all = true, $fetchMode = PDO::FETCH_OBJ)
    {
        $sth = $this->prepare($sql);
        
        $this->bindValues($sth, $where);
        
        $sth->execute();
        
        if ($all) {
            return $sth->fetchAll($fetchMode);
        }
        
        return $sth->fetch($fetchMode);
    }
    
    public function insert($table, $data)
    {
        $camposNomes = implode('`, `', array_keys($data));
        $camposValores = ':' . implode(', :', array_keys($data));
        
        $sql = sprintf('INSERT INTO %s (`%s`) VALUES (%s)', $table, $camposNomes, $camposValores);
        
        $sth = $this->prepare($sql);
        
        $this->bindValues($sth, $data);
        
        $sth->execute();
        
        return $this->lastInsertId();
    }
    
    public function update($table, $data = [], $where) 
    {
        $novosDados = null;
        foreach ($data as $key => $value) {
            $novosDados .= "`$key`=:$key,";
        }
        $novosDados = rtrim($novosDados, ',');
        
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $novosDados, $where);
        $sth = $this->prepare($sql);
        
        $this->bindValues($sth, $data);
        
        return $sth->execute();
    }
    
    public function delete($table, $where, $limit=1)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s LIMIT %s', $table, $where, $limit);
        return $this->exec($sql);
    }
    
}

