<?php 
class Auth{
    private static $ruta = __DIR__ . "/../usuarios.txt";
    
    public static function verificarUser(string $userName, string $ps): bool
    {
        
        if (!file_exists(self::$ruta)){
            try{
                $file = fopen( self::$ruta, "w") or die("Error, no se ha creado el archivo"); //si no existe se crea
                //usuerios de prueba
                $names= ['Bautista', 'Mario', 'Josefina'];
                foreach ($names as $u){   
                    fwrite($file,"{$u}:".rand(0,9999). "\n");
                }
                fclose($file);
                return self::verificarUser($userName, $ps);
            }catch (Error $e){
                print("error al querer escribir: ". $e);
                return false;
            }

        }else{
            try{
                $file = fopen(self::$ruta ,'r');
                while(!feof($file)){
                    $array = explode(':',trim(fgets($file)));
                    if ( $userName === strtolower($array[0]) && $ps === $array[1]) {
                        fclose($file);
                        return true;
                    }
                }
                fclose($file);
            }catch(Error $e){
                print("Error al leer: " . $e);
            }
        }
        return false;
    }   
}