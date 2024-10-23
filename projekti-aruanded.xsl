<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
            <body>
                <h2>Projekti aruanded</h2>
                <table border="1">
                    <tr>
                        <th>Nimi</th>
                        <th>Perekonnanimi</th>
                        <th>Roll</th>
                        <th>Sisselogimisaeg</th>
                        <th>Kinnitusstaatus</th>
                        <th>Lisainfo</th>
                    </tr>
                    <xsl:for-each select="projekt/aruanded/aruanne">
                        <tr>
                            <td><xsl:value-of select="kasutaja/nimi"/></td>
                            <td><xsl:value-of select="kasutaja/perekonnanimi"/></td>
                            <td><xsl:value-of select="kasutaja/roll"/></td>
                            <td><xsl:value-of select="kasutaja/sisselogimisaeg"/></td>
                            <td><xsl:value-of select="kasutaja/kinnitusstaatus"/></td>
                            <td><xsl:value-of select="lisainfo"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
