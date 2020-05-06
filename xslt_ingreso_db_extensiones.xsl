<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" encoding="UTF-8"/>

<xsl:template match="/">
	<xsl:text>INSERT INTO arc_extensiones (Id, Extension) values </xsl:text>
	<xsl:text>&#xa;</xsl:text>
    <xsl:for-each select="root/Archivo">
	  <xsl:text>(</xsl:text>
      <xsl:value-of select="Id" />
	  <xsl:text>,'</xsl:text>
	  <xsl:variable name="var_nombre" select="Nombre"/>
	  <xsl:variable name="var_num_puntos" select="0"/>
	  <xsl:call-template name="get-file-extension">
	    <xsl:with-param name="var_nombre" select="$var_nombre" />
		<xsl:with-param name="var_num_puntos" select="$var_num_puntos" />
      </xsl:call-template>
	  
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

	<xsl:template name="get-file-extension">
	  <xsl:param name="var_nombre" />
	  <xsl:param name="var_num_puntos" />
	  <xsl:choose>
	    <xsl:when test="contains( $var_nombre, '.' )">
	      <xsl:variable name="var_nombre" select="substring-after($var_nombre,'.')"/>
		  <xsl:variable name="var_num_puntos" select="$var_num_puntos + 1"/>
	      <xsl:call-template name="get-file-extension">
		    <xsl:with-param name="var_nombre" select="$var_nombre" />
			<xsl:with-param name="var_num_puntos" select="$var_num_puntos" />
		  </xsl:call-template>
	    </xsl:when>
	    <xsl:otherwise>
		  <xsl:choose>
		    <xsl:when test="$var_num_puntos > 0">
	          <xsl:value-of select="$var_nombre" />
			</xsl:when>
			<xsl:otherwise>
			  <xsl:text>Ninguna</xsl:text>
			</xsl:otherwise>
		  </xsl:choose>
	    </xsl:otherwise>
	  </xsl:choose>
	</xsl:template>

</xsl:stylesheet >