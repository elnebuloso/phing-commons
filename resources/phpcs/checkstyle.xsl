<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" indent="yes" />
    <xsl:decimal-format decimal-separator="." grouping-separator="," />
    <xsl:key name="files" match="file" use="@name" />

    <xsl:template match="checkstyle">
        <html>
            <head>
                <title>Analysis of Coding Conventions</title>
                <style type="text/css">
                    body {margin:10px; padding:0; font:normal 80% arial,helvetica,sanserif; background-color:#ffffff; color:#000000;}

                    a {color:#000000; text-decoration:none;}
                    a:hover {color:#525D76; text-decoration:underline;}

                    .a td {background:#efefef;}
                    .b td {background:#ffffff;}

                    th, td {text-align:left; vertical-align:top;}
                    th {font-weight:bold; background:#cccccc; color:#000000;}
                    table, th, td {font-size:100%; border:none}

                    h1 {font-size:140%; font-weight:bold; background:#525D76; color:#ffffff; padding:5px; margin-right:2px; margin-left:2px;
                    margin-bottom:20px;}
                    h2 {font-weight:bold; font-size:140%; margin-bottom:5;}
                    h3 {font-size:100%; font-weight:bold; background:#525D76; color:#ffffff; text-decoration:none; padding:5px; margin-right:2px;
                    margin-left:2px; margin-bottom:0;}

                    .error {font-weight:bold; background-color:#ff0000!important;}
                    .warning {font-weight:bold; background-color:#FFD800!important;}
                    .info {font-weight:bold; background-color:#267F00!important;}

                    .toplink {margin-bottom:20px; margin-top:10px; padding-bottom:10px;}
                </style>
            </head>

            <body>
                <a name="top"></a>
                <h1>Analysis of Coding Conventions</h1>

                <!-- summary -->
                <xsl:apply-templates select="." mode="summary" />

                <!-- filelist -->
                <xsl:apply-templates select="." mode="filelist" />

                <!-- file -->
                <xsl:apply-templates select="file[@name and generate-id(.) = generate-id(key('files', @name))]" />
            </body>
        </html>

    </xsl:template>


    <!-- filelist -->
    <xsl:template match="checkstyle" mode="filelist">
        <h3>Files</h3>
        <table class="log" border="0" cellpadding="5" cellspacing="2" width="100%">
            <tr>
                <th>Name</th>
                <th>Errors</th>
                <th>Warnings</th>
                <th>Infos</th>
            </tr>
            <xsl:for-each select="file[@name and generate-id(.) = generate-id(key('files', @name))]">

                <!-- Sort method 1: Primary by #error, secondary by #warning, tertiary by #info -->
                <xsl:sort data-type="number" order="descending" select="count(key('files', @name)/error[@severity='error'])" />
                <xsl:sort data-type="number" order="descending" select="count(key('files', @name)/error[@severity='warning'])" />
                <xsl:sort data-type="number" order="descending" select="count(key('files', @name)/error[@severity='info'])" />

                <!-- Sort method 1: Sum(#error+#info+#warning) (uncomment to use, comment method 1) -->
                <!-- <xsl:sort data-type="number" order="descending" select="count(key('files', @name)/error)"/> -->

                <xsl:variable name="errorCount" select="count(key('files', @name)/error[@severity='error'])" />
                <xsl:variable name="warningCount" select="count(key('files', @name)/error[@severity='warning'])" />
                <xsl:variable name="infoCount" select="count(key('files', @name)/error[@severity='info'])" />

                <xsl:if test="count(key('files', @name)/error) &gt; 0">
                    <tr>
                        <xsl:call-template name="alternated-row" />
                        <td>
                            <a href="#f-{translate(@name,'\','/')}">
                                <xsl:value-of select="@name" />
                            </a>
                        </td>
                        <td>
                            <xsl:value-of select="$errorCount" />
                        </td>
                        <td>
                            <xsl:value-of select="$warningCount" />
                        </td>
                        <td>
                            <xsl:value-of select="$infoCount" />
                        </td>
                    </tr>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>


    <!-- file -->
    <xsl:template match="file">
        <xsl:if test="count(error) &gt; 0">
            <a name="f-{translate(@name,'\','/')}"></a>
            <h3>File:
                <xsl:value-of select="@name" />
            </h3>
            <table class="log" border="0" cellpadding="5" cellspacing="2" width="100%">
                <tr>
                    <th>Severity</th>
                    <th>Description</th>
                    <th>Source</th>
                    <th>Line</th>
                </tr>
                <xsl:for-each select="key('files', @name)/*">
                    <xsl:sort data-type="number" order="ascending" select="@line" />
                    <tr>
                        <xsl:call-template name="alternated-row" />
                        <td>
                            <xsl:call-template name="warning-level" />
                            <xsl:value-of select="@severity" />
                        </td>
                        <td>
                            <xsl:value-of select="@message" />
                        </td>
                        <td>
                            <xsl:value-of select="@source" />
                        </td>
                        <td>
                            <xsl:value-of select="@line" />
                        </td>
                    </tr>
                </xsl:for-each>
            </table>
            <div class="toplink">
                <a href="#top">Back to top</a>
            </div>
        </xsl:if>
    </xsl:template>


    <!-- summary -->
    <xsl:template match="checkstyle" mode="summary">
        <h3>Summary</h3>
        <xsl:variable name="fileCount" select="count(file[@name and generate-id(.) = generate-id(key('files', @name))])" />
        <xsl:variable name="errorCount" select="count(file/error[@severity='error'])" />
        <xsl:variable name="warningCount" select="count(file/error[@severity='warning'])" />
        <xsl:variable name="infoCount" select="count(file/error[@severity='info'])" />
        <table class="log" border="0" cellpadding="5" cellspacing="2" width="100%">
            <tr>
                <th>Files</th>
                <th>Errors</th>
                <th>Warnings</th>
                <th>Infos</th>
            </tr>
            <tr>
                <xsl:call-template name="alternated-row" />
                <td>
                    <xsl:value-of select="$fileCount" />
                </td>
                <td>
                    <xsl:value-of select="$errorCount" />
                </td>
                <td>
                    <xsl:value-of select="$warningCount" />
                </td>
                <td>
                    <xsl:value-of select="$infoCount" />
                </td>
            </tr>
        </table>
    </xsl:template>


    <!-- alternated-row -->
    <xsl:template name="alternated-row">
        <xsl:attribute name="class">
            <xsl:if test="position() mod 2 = 1">a</xsl:if>
            <xsl:if test="position() mod 2 = 0">b</xsl:if>
        </xsl:attribute>
    </xsl:template>


    <!-- warning-level -->
    <xsl:template name="warning-level">
        <xsl:attribute name="class">
            <xsl:value-of select="@severity" />
        </xsl:attribute>
    </xsl:template>


</xsl:stylesheet>