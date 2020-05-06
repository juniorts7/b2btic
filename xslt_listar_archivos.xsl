<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="utf-8" indent="yes" />

<xsl:template match="/">
<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/bootstrap.min.css" />
  <script src="/jquery-3.3.1.min.js"></script>
  <script src="/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
  <h2>Listado de Archivos</h2>
  <table class="table table-responsive table-striped table-bordered table-hover" style="margin:auto; width:100%;">
    <tr bgcolor="#9acd32">
      <th style="text-align:left">Id</th>
	  <th style="text-align:left">Extension</th>
      <th style="text-align:left">Nombre</th>
    </tr>
    <xsl:for-each select="root/Archivo">
    <tr>
      <td><xsl:value-of select="Id" /></td>
	  <td><xsl:value-of select="Extension" /></td>
      <td><xsl:value-of select="Nombre" /></td>
    </tr>
    </xsl:for-each>
  </table>
  </div>
</body>
</html>
</xsl:template>

</xsl:stylesheet> 