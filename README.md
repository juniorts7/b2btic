# b2btic
Test de b2btic

Procedemos a explicar como funciona el software de la prueba.

El primer punto está en la url:
http://andrea.zionika.a2hosted.com/index.php/buscar_archivo/ingresar_info
Aquí se consume el web service "BuscarArchivo", php devuelve un arreglo de objetos del cual se crea un archivo xml donde se guarda la información (xml_ingreso_db.xml); despues usamos dos archivos XSLT para crear los inserts para llenar las tablas de la base de datos.
xslt_ingreso_db_archivos.xsl para generar inserts de la tabla arc_archivos.
xslt_ingreso_db_extensiones.xsl para generar inserts de la tabla arc_extensiones.
Ejecutamos la consulta y se ingresa la información a las tablas.
El XSLT de extensiones tiene un template que es recursivo y tiene contador.

El segundo punto está en la url:
http://andrea.zionika.a2hosted.com/index.php/buscar_archivo/listar_archivos
Este reporte muestra el listado de archivos que está almacenado en las dos tablas.  Se construye un xml con esa información, el cual es procesado por una plantilla XSLT (xslt_listar_archivos.xsl) que transforma la información a HTML.
La pagina es responsive (Bootstrap).

El tercer punto está en la url:
http://andrea.zionika.a2hosted.com/index.php/buscar_archivo/cantidad_archivos
Este reporte muestra la cantidad de archivos agrupada por extension.  Se construye un xml con esa información, el cual es procesado por una plantilla XSLT (xslt_cantidad_archivos.xsl) que transforma la información a HTML.
La pagina es responsive (Bootstrap).

El archivo donde está la logica de la aplicación está en /application/models/Model_buscar_archivo.php

Otros archivos clave están en la raíz:
- xml_ingreso_db.xml: Guarda informacion en formato xml del web service.
- xslt_cantidad_archivos.xsl: XSLT que transforma reporte de cantidades de archivos a formato HTML.
- xslt_ingreso_db_archivos.xsl: XSLT que genera inserts para tabla arc_archivos.
- xslt_ingreso_db_extensiones.xsl: XSLT que genera inserts para tabla arc_extensiones.
- xslt_listar_archivos.xsl: XSLT que transforma reporte de listado de archivos a formato HTML.
- zionika1_b2btic.sql: Base de datos con estructura de las dos tablas, no tiene datos.

Muchas gracias.

RAFAEL TELLO.
