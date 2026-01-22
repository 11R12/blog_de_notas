<?php

namespace BlogDeNotas\AuthServices;


//Nota: Aunque se pueda hacer uso solo de la funcion validate()
//llamando estaticamente a los patrones, las demas funciones fueron 
//creadas por motivos semanticos. Tambien considere dejarlo proque 
//pense en crear un interface que declare dichos metodos y ya tendria el
//trabajo adelantado xd 


class UserAuthServices{

	static string $numberRegex = '/^[0-9\-\+\s]{8,20}$/';

	static string $nameRegex = '/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/';

	static string $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d\s])[^\s]{8,}$/';





	public static function validateName(string $string): bool{
		try{

			return	UserAuthServices::validate(UserAuthServices::$nameRegex, $string);

		}catch(\Exception $e){ 

			throw new \Exception('Error: no se pudo validar formato del nombre','', $e);
		} 
	}





	public static function validateTelephone(string $string): bool{

		try{

			return	UserAuthServices::validate(UserAuthServices::$numberRegex, $string);

		}catch(\Exception $e){ 

			throw new \Exception('Error: no se pudo validar el formato del numero','', $e);
		}
	}





	public static function validatePassword(string $string): bool{

		try{

			return	UserAuthServices::validate(UserAuthServices::$passwordRegex, $string);

		}catch(\Exception $e){ 

			throw new \Exception('Error: no se pudo validar el formato de la contraseña','', $e);
		}
	}





	public static function validateEmail(string $string): bool{

		$result = filter_var($string, FILTER_VALIDATE_EMAIL);

		if($result === false) return false;

		return true;
	}





	public static function validate(string $pattern, string $string): bool{

		return match(preg_match($pattern, $string)) {
			1 => true,
			0 => false,
			false => throw new \Exception('Error: compruebe si el patron regex no es valido'),
			default => false,
		};

	}





	public static function verifyPassword(string $password,string $hash): bool {

		return password_verify($password, $hash);
	}

}