<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:msxsl="urn:schemas-microsoft-com:xslt" exclude-result-prefixes="msxsl">

	<xsl:output method="html" indent="yes" encoding="utf-8"/>

	<xsl:template match="/">
		<html>
			<head>
				<title>Projekti Aruanded</title>
		
				<script src="script.js"></script>
			</head>
			<body>
				<h2>Projekti Aruanded</h2>

		
				<label for="roleFilter">Filtreeri rolli järgi:</label>
				<input type="text" id="roleFilter" onkeyup="filterByRole()" placeholder="Sisesta roll" />

				<label for="nameSearch">Otsi nime järgi:</label>
				<input type="text" id="nameSearch" onkeyup="searchByName()" placeholder="Sisesta nimi" />

				<table id="aruandedTable" border="1" cellpadding="5">
					<tr>
						<th onclick="sortTable(0)">Nimi</th>
						<th onclick="sortTable(1)">Perekonnanimi</th>
						<th onclick="sortTable(2)">Roll</th>
						<th onclick="sortTable(3)">Sisselogimisaeg</th>
						<th onclick="sortTable(4)">Kinnitusstaatus</th>
						<th>Lisainfo</th>
					</tr>

					<xsl:for-each select="projekt/aruanded/aruanne">
						<tr>
							<td>
								<xsl:value-of select="kasutaja/nimi"/>
							</td>
							<td>
								<xsl:value-of select="kasutaja/perekonnanimi"/>
							</td>
							<td>
								<xsl:value-of select="kasutaja/roll"/>
							</td>
							<td>
								<xsl:value-of select="kasutaja/sisselogimisaeg"/>
							</td>
							<td>
								<xsl:value-of select="kasutaja/kinnitusstaatus"/>
							</td>
							<td>
								<xsl:value-of select="lisainfo"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
