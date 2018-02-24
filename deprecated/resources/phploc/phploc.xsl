<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:template match="phploc">
        <html>
            <head>
                <title>PHP LOC Report</title>
                <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
                <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />
            </head>
            <body>
                <div class="container">
                    <div class="page-header">
                        <h1>PHP LOC
                            <small>Report</small>
                        </h1>
                    </div>

                    <br />
                    <table class="table table-striped">
                        <xsl:for-each select="//phploc/*">
                            <tr>
                                <td>
                                    <xsl:value-of select="name(.)" />
                                </td>
                                <td>
                                    <xsl:value-of select="current()" />
                                </td>
                            </tr>
                        </xsl:for-each>
                    </table>
                </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>