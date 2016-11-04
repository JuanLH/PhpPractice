<?php
    class DbPDO{
        private $host;
        private $password;
        private $dbname;
        private $port;
        private $username;
        private $conn;
        private $driverName;
        
        public function __construct($driverName, $host, $port, $username, $password, $dbname) {
                $this->host = $host;
                $this->password = $password;
                $this->dbname = $dbname;
                $this->port = $port;
                $this->username = $username;
                $this->driverName = $driverName;
                $this->connect();
        }
        
        private function connect() {
            switch($this->driverName) {
                case 'sqlsrv':
                    $dsn = $this->driverName . ":Server=" . $this->host . ";Database=" . $this->dbname;
                    break;
                default:
                    $dsn = $this->driverName.':dbname='.$this->dbname.';host='.$this->host.'; port = '.$this->port.'';
            }

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                return false;
            }

        }
        
        public function execSelect ($sql){
            return $this->conn->query($sql);
        }
        
        public function exec ($sql){
            return $this->conn->exec($sql);
        }
        
        public function closeConn(){
            $this->conn=null;
        }
        
        public function getConn(){
            return $this->conn;
        }
        
        public function insertCategory($descripcion){
            try{
                $result = $this->execSelect('SELECT max(codigo_categoria) cod FROM dbo.categorias');
                //print("Return next row as an array indexed by column name\n <br>");


                
                $result= $result->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
                if($result[0]==null){
                    $cod = 1;
                }
                else{
                    $cod=$result[0]+1;
                }
                
                
                
                $prep = $this->conn->prepare('INSERT INTO dbo.categorias(codigo_categoria, descripcion) VALUES (?, ?);');
                $prep->bindParam(1,$cod);
                $prep->bindParam(2,$descripcion);
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }

        public function registrarUsuario($array){
            try{
                $result = $this->execSelect('select max(codigo_usuario) from dbo.usuarios');
                //print("Return next row as an array indexed by column name\n <br>");
                $result= $result->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
                if($result[0]==null){
                    $cod = 1;
                }
                else{
                    $cod=$result[0]+1;
                }
                
                
                
                $prep = $this->conn->prepare('INSERT INTO [dbo].[usuarios] 
                                                (codigo_usuario,nombre,sexo
                                               ,correo,clave,web
                                               ,fehca_registro,estado)
                                                VALUES
                                               (?,?,?,?,?,?,?,?);');
                $prep->bindParam(1,$cod);
                $prep->bindParam(2,$array[0]);
                $prep->bindParam(3,$array[1]);
                $prep->bindParam(4,$array[2]);
                $prep->bindParam(5,$array[3]);
                $prep->bindParam(6,$array[4]);
                $prep->bindParam(7,$array[5]);
                $prep->bindParam(8,$array[6]);
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }

        public function modificarUsuario($array){
            try{
                $prep = $this->conn->prepare('UPDATE dbo.usuarios
                                               SET 
                                                  nombre = ?
                                                  ,sexo = ?
                                                  ,correo = ?
                                                  ,clave = ?
                                                  ,web = ?
                                                  ,fehca_registro = ?
                                                  ,estado = ?
                                             WHERE codigo_usuario = ?');
                /*$cmd = 'UPDATE dbo.usuarios
                                               SET 
                                                  nombre = \''.$array[0].'\'
                                                  ,sexo = \''.$array[1].'\'
                                                  ,correo = \''.$array[2].'\'
                                                  ,clave = \''.$array[3].'\'
                                                  ,web = \''.$array[4].'\'
                                                  ,fehca_registro = \''.$array[5].'\'
                                                  ,estado = '.$array[6].'
                                             WHERE codigo_usuario = '.$array[7].'';*/
                //echo $cmd;                            
                //return $this->exec($cmd);
                
                $prep->bindParam(1,$array[0]);
                $prep->bindParam(2,$array[1]);
                $prep->bindParam(3,$array[2]);
                $prep->bindParam(4,$array[3]);
                $prep->bindParam(5,$array[4]);
                $prep->bindParam(6,$array[5]);
                $prep->bindParam(7,$array[6]);
                $prep->bindParam(8,$array[7]);
                $prep->execute();
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }

        public function getUsuarios(){
            $result;
            $sql = 'SELECT codigo_usuario,nombre,sexo
                    ,correo,clave,web
                    ,fehca_registro
                    FROM [dbo].[usuarios] where estado = 0';
            try{
                $result = $this->execSelect($sql);     
                return $result;    
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
              
        }

        public function getUsuario($cod){
            $result;
            $sql = 'SELECT codigo_usuario,nombre,sexo
                    ,correo,clave,web
                    ,fehca_registro
                    FROM [dbo].[usuarios] where estado = 0 and codigo_usuario ='.$cod;
            try{
                $result = $this->execSelect($sql); 
                //var_dump($result);    
                return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;     
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
              
        }

        public function login($user,$pass){
            $result;
            $sql = 'SELECT codigo_usuario
                    FROM [dbo].[usuarios] where estado = 0 and nombre =\''.$user.'\' and clave=\''.$pass.'\'';
             echo $sql;   
            try{
                $result = $this->execSelect($sql); 
                //var_dump($result);    
                return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;     
            }
            catch(PDOException $e){
                
                return null;
            }

        }
    }
?>  