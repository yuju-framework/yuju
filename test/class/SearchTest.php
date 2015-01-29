<?php

/**
 * Number Test File
 *
 * PHP version 5
 *
 * Copyright individual contributors as indicated by the @authors tag.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: SearchTest.php 139 2013-11-14 09:13:50Z cristianmv $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * NumberTest Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class SearchTest extends PHPUnit_Framework_TestCase
{

    protected $_busqueda;

    /**
     * Set Up
     * 
     * @return void
     */
    protected function setUp()
    {
        $this->_busqueda = new PagesLang();
    }

    public function testInt()
    {
        
        $this->setUp();
        
        $array["from-numint"]="0";
        $array["to-numint"]="22";
        $this->assertEquals(2, $this->_busqueda->search($array)->count());
        $array= array();
		$array["from-numint"]="0";
        $array["to-numint"]="13";        
        $this->assertEquals(1, $this->_busqueda->search($array)->count());
        $array= array();
		$array["from-numint"]="0";
        $array["to-numint"]="5";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());
		
		//búsqueda erronea
		$array= array();
		$array["from-numint"]="z";
        $array["to-numint"]="13";
        $this->assertEquals(false,$this->_busqueda->search($array));
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }


    public function testDecimal()
    {
        $array= array();
        $array["from-numdeci"]="0";
        $array["to-numdeci"]="16";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-numdeci"]="0";
        $array["to-numdeci"]="25";      
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-numdeci"]="0";
        $array["to-numdeci"]="11.6";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-numdeci"]="j";
        $array["to-numdeci"]="22";
        $this->assertEquals(false,$this->_busqueda->search($array));  
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }

    public function testFloat()
    {
	
        $array= array();
        $array["from-cfloat"]="300";
        $array["to-cfloat"]="356.3";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cfloat"]="300";
        $array["to-cfloat"]="360";      
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cfloat"]="300";
        $array["to-cfloat"]="356.1";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-cfloat"]="j";
        $array["to-cfloat"]="360";
        $this->assertEquals(false,$this->_busqueda->search($array));  	
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }

    public function testBigInt()
    {
		$array= array();
        $array["eq-cbigint"]="2";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-cbigint"]="2";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["from-cbigint"]="-9223372036854775809";
        $array["to-cbigint"]="1";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cbigint"]="-800";
        $array["to-cbigint"]="3";      
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cbigint"]="-9223372036854775808";
        $array["to-cbigint"]="356.2";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-cbigint"]="j";
        $array["to-cbigint"]="3";
        $this->assertEquals(false,$this->_busqueda->search($array));  		
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }

	  public function testDouble()
      {
		$array= array();
        $array["eq-cdouble"]="2000";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-cdouble"]="00";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["from-cdouble"]="15";
        $array["to-cdouble"]="2555";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cdouble"]="-2500";
        $array["to-cdouble"]="3000";      
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-cdouble"]="j";
        $array["to-cdouble"]="3000";
        $this->assertEquals(false,$this->_busqueda->search($array));  
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
      } 

    public function testTinyTnt()
    {
		$array= array();
        $array["eq-ctinyint"]="50";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-ctinyint"]="0";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["from-ctinyint"]="15";
        $array["to-ctinyint"]="70";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-ctinyint"]="-2500";
        $array["to-ctinyint"]="50";      
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-ctinyint"]="j";
        $array["to-ctinyint"]="3000";
        $this->assertEquals(false,$this->_busqueda->search($array));  
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }
   
    public function testMedium()
    {
		$array= array();
        $array["eq-cmediumint"]="200";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-cmediumint"]="00";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["from-cmediumint"]="15";
        $array["to-cmediumint"]="70";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-cmediumint"]="-2500";
        $array["to-cmediumint"]="200";      
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-cmediumint"]="j";
        $array["to-cmediumint"]="3000";
        $this->assertEquals(false,$this->_busqueda->search($array));  

		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();		
    }
    
    public function testSmallint()
    {
		$array= array();
        $array["eq-csmallint"]="200";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-csmallint"]="00";
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["from-csmallint"]="15";
        $array["to-csmallint"]="70";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["from-csmallint"]="-2500";
        $array["to-csmallint"]="200";      
        $this->assertEquals(2,$this->_busqueda->search($array)->count());  
        
		//búsqueda erronea
		$array= array();
		$array["from-csmallint"]="j";
        $array["to-csmallint"]="3f0";
        $this->assertEquals(false,$this->_busqueda->search($array));  
		
		//comprovar los errores
		echo "Parametros recibidos erroneos:\n";
		$errors = Error::getErrors(); 		
		$cont = count($errors);
		for($i=0;$i<$cont;$i++) {
			echo "Error: ".$errors[$i][1]."\n";
        }
		Error::clean();
    }

    public function testBit()
    {
		$array= array();
        $array["eq-bit"]="1";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
        $array= array();
		$array["eq-bit"]="12";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
    }
	

    public function testChar()
    {
		$array= array();
        $array["eq-cchar"]="a";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-cchar"]="a";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
    }
	
    public function testLongText()
    {
		$array= array();
        $array["eq-clongt"]="aaaaa";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-clongt"]="aaa";
        $this->assertEquals(1,$this->_busqueda->search($array)->count()); 
    }

    public function testVarchar()
    {
		$array= array();
        $array["eq-nombre"]="carlos";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-nombre"]="r";
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 
    }

    public function testMediumText()
    {
		$array= array();
        $array["eq-cmediumt"]="medium2";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-cmediumt"]="me";
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 
    }
	
    public function testText()
    {
		$array= array();
        $array["eq-ctext"]="text";
        $this->assertEquals(0,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-ctext"]="texto1";
        $this->assertEquals(1,$this->_busqueda->search($array)->count()); 
    }

    public function testTinyText()
    {
		$array= array();
        $array["eq-ctinyt"]="ab";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["like-ctinyt"]="b";
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 
    }
	
    public function testYear()
    {
		$array= array();
        $array["eq-cyear"]="2000";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["ini-cyear"]="1990";
        $array["end-cyear"]="2000";		
        $this->assertEquals(1,$this->_busqueda->search($array)->count()); 
		$array= array();
        $array["ini-cyear"]="1990";		
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 		
    }

    public function tesTime()
    {
		$array= array();
        $array["eq-ctime"]="14:00:00";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["ini-ctime"]="14:00:00";
        $array["end-ctime"]="15:00:00";		
        $this->assertEquals(1,$this->_busqueda->search($array)->count()); 
		$array= array();
        $array["ini-ctime"]="15:00:00";		
        $this->assertEquals(1,$this->_busqueda->search($array)->count()); 	
    }

    public function testDateTime()
    {
		$array= array();
        $array["eq-cdatetime"]="2000-05-06 02:00:00";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["ini-cdatetime"]="1990-05-06 02:00:00";
        $array["end-cdatetime"]="2000-05-06 02:00:00";
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 
		$array= array();
        $array["ini-cdatetime"]="2001-05-06 02:00:00";	
        $this->assertEquals(0,$this->_busqueda->search($array)->count()); 	
    }

    public function testDate()
    {
		$array= array();
        $array["eq-fecha"]="2002-02-09";
        $this->assertEquals(1,$this->_busqueda->search($array)->count());  
		$array= array();
        $array["ini-fecha"]="2001-01-20";
        $array["end-fecha"]="2002-02-09";
        $this->assertEquals(2,$this->_busqueda->search($array)->count()); 
		$array= array();
        $array["end-fecha"]="2001-01-19";	
        $this->assertEquals(0,$this->_busqueda->search($array)->count()); 	
    }	

}
