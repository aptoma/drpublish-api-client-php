<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:DrLib="http://aptoma.no/xml/drlib">
	<xsl:output method="html" version="1.0" encoding="UTF-8"	indent="yes" />
	<xsl:template match="DrLib:documentation">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
        <head>
            <title>DrPublish API doc</title>
            <script type="text/javascript" src="inc/jquery.js"></script>
            <link rel="stylesheet" href="inc/toc.css" type="text/css" media="all" charset="utf-8" />
        </head>
        <body>

         <h1>DrPublish API request documentation</h1>
            <h2 class="no-sec">Table of contents</h2>
            	<ul class="toc1"> </ul>
            <div id="content">
            <h2 id="general">General</h2>
                <h3 id="general-parameters">Parameters</h3>
                <xsl:for-each select="general/parameters/*">
                    <xsl:variable name="rvar" select="name()" />
                    <xsl:for-each select="parameter">
                        <xsl:variable name="name-id" select="generate-id(name)" />
                        <h4 id="general-parameters-{$name-id}"><xsl:value-of select="name" /> [<xsl:value-of select="$rvar" />]</h4>
                        <div class="description">
                            <xsl:copy-of select="description" />
                        </div>
                        <h5 id="general-parameters-{$name-id}-example">Example</h5>
                        <div class="example">
                            <xsl:copy-of select="example" />
                        </div>
                        <h6 id="general-parameters-{$name-id}-incompatibilities">Incompatibilities</h6>
                        <div class="incompatibilities">
                            <xsl:copy-of select="incompatibilities" />
                        </div>
                    </xsl:for-each>
                </xsl:for-each>
            <h2 id="routes">Routes</h2>
                <xsl:for-each select="route">
                 <xsl:variable name="route-id" select="generate-id(link)" />
                <h3 id="routes-{$route-id}"><xsl:value-of select="link" /></h3>
                <div class="indent">
                    <div class="description"><xsl:copy-of select="description" /></div>
                    <xsl:choose>
                        <xsl:when test="link-replacement-values">
                            <div>
                                <h4 id="routes-{$route-id}-link-replacement-values">Link replacement values</h4>
                                <xsl:copy-of select="link-replacement-values" />
                            </div>
                        </xsl:when>
                    </xsl:choose>
                    <xsl:choose>
                        <xsl:when test="example">
                            <div class="example">
                                <h4 id="routes-{$route-id}-example">Example</h4>
                                <xsl:copy-of select="example"/>
                            </div>
                        </xsl:when>
                    </xsl:choose>
                    <xsl:choose>
                        <xsl:when test="link-variations">
                           <h4 id="routes-{$route-id}-link-variations">Link variations</h4>
                           <xsl:for-each select="link-variations/variation">
                               <xsl:variable name="link-id" select="generate-id(link)" />
                               <h5 id="routes-{$route-id}-{$link-id}-link-variations"><xsl:value-of select="link" /></h5>
                               <xsl:choose>
                               <xsl:when test="example">
                                   <div class="example">
                                       <h6 id="routes-{$route-id}-{$link-id}-example">Example</h6>
                                       <xsl:copy-of select="example"/>
                                   </div>
                               </xsl:when>
                               </xsl:choose>
                           </xsl:for-each>
                        </xsl:when>
                    </xsl:choose>
                    <xsl:choose>
                        <xsl:when test="parameters">
                            <h4 id="routes-{$route-id}-parameters">Parameters</h4>
                             <xsl:for-each select="parameters/*">
                                  <xsl:variable name="rvar" select="name()" />
                                   <xsl:for-each select="parameter">
                                       <xsl:variable name="parameter-id" select="generate-id()" />
                                   <h5 id="routes-{$route-id}-{$parameter-id}"><xsl:value-of select="name" /> [<xsl:value-of select="$rvar" />]</h5>
                                   <div class="description">
                                        <xsl:copy-of select="description" />
                                   </div>
                                   <xsl:choose>
                                       <xsl:when test="name-replacement-values">
                                             <h6 id="routes-{$route-id}-{$parameter-id}-name-replacement-values">Name replacement values</h6>
                                           <div>
                                             <xsl:copy-of select="name-replacement-values"/>
                                           </div>
                                       </xsl:when>
                                   </xsl:choose>
                                   <xsl:choose>
                                   <xsl:when test="example">
                                       <div id="routes-{$route-id}-{$parameter-id}-example" class="example">
                                           <h6>Example</h6>
                                           <xsl:copy-of select="example"/>
                                       </div>
                                   </xsl:when>
                                   </xsl:choose>
                                   <xsl:choose>
                                       <xsl:when test="incompatibilities">
                                           <h6 id="routes-{$route-id}-{$parameter-id}-incompatibilities">Incompatibilities</h6>
                                           <div class="incompatibilities">
                                               <xsl:copy-of select="incompatibilities"/>
                                           </div>
                                       </xsl:when>
                                   </xsl:choose>
                               </xsl:for-each>
                           </xsl:for-each>
                        </xsl:when>
                    </xsl:choose>
                </div>
            </xsl:for-each>
            </div>
            <script type="text/javascript">
            <xsl:text disable-output-escaping="yes"><![CDATA[
                    $(document).ready(function () {
                            var h = [0, 0, 0, 0, 0], i, s, level, toc = $('.toc2');
                            $('h2,h3,h4,h5').each(function () {
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