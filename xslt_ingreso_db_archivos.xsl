<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" encoding="UTF-8"/>

<xsl:template match="/">
	<xsl:text>INSERT INTO arc_archivos (Id, Nombre) values </xsl:text>
	<xsl:text>&#xa;</xsl:text>
    <xsl:for-each select="root/Archivo">
	  <xsl:text>(</xsl:text>
      <xsl:value-of select="Id" />
	  <xsl:text>,'</xsl:text>
	  <xsl:variable name="var_nombre" select="Nombre"/>
	  <xsl:variable name="comilla">'</xsl:variable>
	  <xsl:choose>
		<xsl:when test="contains( $var_nombre, $comilla )">
			<xsl:variable name="slash">\</xsl:variable>
			<xsl:value-of select="concat(substring-before($var_nombre,$comilla),$slash,$comilla,substring-after($var_nombre,$comilla))" />
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="Nombre" />
		</xsl:otherwise>
	  </xsl:choose>
	  
	  <xsl:choose>
	    <xsl:when test="position() = last()">
		  <xsl:text>')</xsl:text>
		</xsl:when>
		<xsl:otherwise>
	      <xsl:text>'),&#xa;</xsl:text>
		</xsl:otherwise>
	  </xsl:choose>
    </xsl:for-each>
	
</xsl:template>

</xsl:stylesheet >