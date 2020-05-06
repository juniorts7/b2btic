<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Model_buscar_archivo extends CI_Model {

	// lee web service BuscarArchivo
	// el resultado que devuelve php (arrego de objetos) se convierte a xml
	// por medio de un xslt se generan inserts para ingresar informacion a base de datos
	public function ingresar_info()
	{ 
		$client = new SoapClient("http://test.analitica.com.co/AZDigital_Pruebas/WebServices/ServiciosAZDigital.wsdl");
		$client->__setLocation('http://test.analitica.com.co/AZDigital_Pruebas/WebServices/SOAP/index.php');
		//var_dump($client->__getFunctions()); 
		//var_dump($client->__getTypes()); 
		$params = array(
					'Condiciones' => array(
						'Condicion' => array(
							'Tipo' => 'FechaInicial',
							'Expresion' => '2019-07-01 00:00:00'
						)
					)
				); //print_r($params);exit;
		$result = $client->BuscarArchivo($params); //$xml = $client->__getLastRequest(); var_dump($xml);exit;
		// convertimos el resultado en xml
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n<root>\n";
		for ($i=0; $i < sizeof($result->Archivo); $i++) {
			$nombre = str_replace('&','&amp;',$result->Archivo[$i]->Nombre);
			$nombre = str_replace('<','&lt;',$nombre);
			$xml .= '<Archivo>'."\n";
			$xml .= '<Id>'.$result->Archivo[$i]->Id.'</Id>'."\n";
			$xml .= '<Nombre>'.$nombre.'</Nombre>'."\n";
			$xml .= '</Archivo>'."\n";
		}
		$xml .= "</root>"; //echo $xml;exit;
		file_put_contents('xml_ingreso_db.xml', $xml); //$xml = file_get_contents('xml_ingreso_db.xml'); //echo $xml;exit;
		
		// generamos inserts para la base de datos
		// ejecutamos xslt para generar inserts de tabla arc_archivos
		$xml = new DOMDocument;
		$xml->load('xml_ingreso_db.xml'); 
		$xsl = new DOMDocument;
		$xsl->load('xslt_ingreso_db_archivos.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); //echo $proc->transformToXML($xml);return true;
		$sql_archivos = $proc->transformToXML($xml);
		// ejecutamos xslt para generar inserts de tabla arc_extensiones
		$xsl = new DOMDocument;
		$xsl->load('xslt_ingreso_db_extensiones.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); //echo $proc->transformToXML($xml);return true;
		$sql_extensiones = $proc->transformToXML($xml);
		
		// borramos contenido de tablas (para que no se repita informacion si se ejecuta el script varias veces)
		$this->load->database();
	    $sql   = "DELETE FROM arc_archivos";
	    $query = $this->db->query($sql, array());
	    $sql   = "DELETE FROM arc_extensiones";
	    $query = $this->db->query($sql, array());
		// ejecutamos inserts en base de datos
		$query = $this->db->query($sql_archivos, array());
		$query = $this->db->query($sql_extensiones, array());
		echo "<html><body><center><br><br>Número de filas insertadas: ".$this->db->affected_rows().'</center></body></html>';
		
		return true;
	}
	
	// despliega listado de archivos con informacion de las 2 tablas
	// se almacena la info de la base de datos en una variable con contenido xml
	// por ultimo un xslt muestra la informacion en html
	public function listar_archivos()
	{
		$this->load->database();
		$sql = "SELECT a.Id,e.Extension,a.Nombre FROM arc_extensiones e JOIN arc_archivos a ON e.Id=a.Id";
		$query = $this->db->query($sql, array());
		// almacenamos el resultado en un xml
		$xml_ini = '<?xml version="1.0" encoding="UTF-8"?>'."\n<root>\n";
		if ($query->num_rows() > 0) { 
			foreach ($query->result_array() as $row) { //$nombre = $row['Nombre'];
				$nombre = str_replace('&','&amp;',$row['Nombre']);
				$nombre = str_replace('<','&lt;',$nombre);
				$xml_ini .= '<Archivo>'."\n";
				$xml_ini .= '<Id>'.$row['Id'].'</Id>'."\n";
				$xml_ini .= '<Extension>'.$row['Extension'].'</Extension>'."\n";
				$xml_ini .= '<Nombre>'.$nombre.'</Nombre>'."\n";
				$xml_ini .= '</Archivo>'."\n";
			}
		} 
		$xml_ini .= "</root>"; //echo $xml;exit;
		
		// ahora ejecutamos el xslt para generar el archivo html
		$xml_end = new DOMDocument;
		$xml_end->loadXML($xml_ini); 
		$xsl = new DOMDocument;
		$xsl->load('xslt_listar_archivos.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); 
		echo $proc->transformToXML($xml_end);
		
		return true;
	}
	
	// reporte que muestra cantidad de archivos agrupados por extension
	// otra vez se almacena la info de la base de datos en una variable con contenido xml
	// por ultimo un xslt muestra la informacion en html
	public function cantidad_archivos()
	{
		$this->load->database();
		$sql = "SELECT COUNT(Id) Cantidad, Extension FROM `arc_extensiones` GROUP BY Extension";
		$query = $this->db->query($sql, array());
		// almacenamos el resultado en un xml
		$xml_ini = '<?xml version="1.0" encoding="UTF-8"?>'."\n<root>\n";
		if ($query->num_rows() > 0) { 
			foreach ($query->result_array() as $row) { 
				$extension = str_replace('&','&amp;',$row['Extension']);
				$extension = str_replace('<','&lt;',$extension);
				$xml_ini .= '<Reporte>'."\n";
				$xml_ini .= '<Extension>'.$extension.'</Extension>'."\n";
				$xml_ini .= '<Cantidad>'.$row['Cantidad'].'</Cantidad>'."\n";
				$xml_ini .= '</Reporte>'."\n";
			}
		} 
		$xml_ini .= "</root>"; //echo $xml;exit;
		
		// ahora ejecutamos el xslt para generar el archivo html
		$xml_end = new DOMDocument;
		$xml_end->loadXML($xml_ini); 
		$xsl = new DOMDocument;
		$xsl->load('xslt_cantidad_archivos.xsl');
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); 
		echo $proc->transformToXML($xml_end);
		
		return true;
	}
}
