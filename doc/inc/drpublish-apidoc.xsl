<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:DrPublish="http://aptoma.no/xml/drpublish">
	<xsl:output method="html" version="1.0" encoding="UTF-8"	indent="yes" />
	<xsl:template match="DrPublish:links">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
        <head>
            <title>DrPublish API doc</title>
            <script type="text/javascript" src="inc/jquery.min.js"></script>
            <link rel="stylesheet" href="inc/toc.css" type="text/css" media="all" charset="utf-8" />
        </head>
        <body>

         <h1>DrPublish API request documentation</h1>
            <h2 class="no-sec">Table of contents</h2>
            	<ul class="toc"> </ul>
            <xsl:for-each select="DrPublish:link">
            <h2 id="{name}"><xsl:value-of select="name" /></h2>
            <div class="indent">
            <em class="description"><xsl:value-of select="description" /></em>
            <h3 id="{name}-uri">Request URI</h3>
             <xsl:value-of select="uri"/>
            <h3 id="{name}-parameters">Parameters</h3>
                <div class="indent">
                    <xsl:for-each select="parameters/parameter">
                        <h4><xsl:value-of select="name"/></h4>
                        <div class="indent">
                            <em><xsl:value-of select="description"/></em>
                            <p><strong>type: </strong><xsl:value-of select="type" /></p>
                            <p><strong>mandatory: </strong><xsl:value-of select="mandatory" /></p>
                            <p><strong>allowed values: </strong><xsl:value-of select="allowedValues" /></p>
                        </div>
                    </xsl:for-each>

                </div>
            </div>
        </xsl:for-each>
            <script type="text/javascript">
            <xsl:text disable-output-escaping="yes"><![CDATA[
                    $(document).ready(function () {
                            var h = [0, 0, 0, 0, 0], i, s, level, toc = $('.toc');
                            $('h2').each(function () {
                                    if (!$(this).hasClass('no-sec')) {
                                            s = [];
                                            level = this.nodeName.match(/H([2-6])/)[1] - 2;
                                            h[level]++;
                                            for (i = 0; i < h.length; i++) {
                                                    if (i > level) {
                                                            h[i] = 0;
                                                    } else {
                                                            s.push(h[i]);
                                                    }
                                            }
                                            $(this).html('<span class="secnum">' + s.join('.') + '</span><a href="#' + this.id + '">' + $(this).text() + '</a>');
                                            $(toc).append(
                                                    $('<li>' + $(this).html() + '</li>').find('span').css('width', (4 + level) + 'em').end()
                                            );
                                    }
                            });

                            $('.example-code').each(function () {
                                    elem = $(this);
                            });
                    });

            ]]></xsl:text>
            </script>
       </body>
        </html>
	</xsl:template>
</xsl:stylesheet>