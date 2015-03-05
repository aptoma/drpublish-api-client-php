<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:DrLib="http://aptoma.no/xml/drlib">
	<xsl:output method="html" version="1.0" encoding="UTF-8"	indent="yes" />
	<xsl:template match="DrLib:documentation">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
        <head>
            <title>DrPublish API doc</title>
            <script src="inc/jquery-2.1.0.min.js"></script>
            <link rel="stylesheet" href="inc/bootstrap.min.css"/>
            <link rel="stylesheet" href="https://aptoma.github.io/aptoma-design-guide/compiled/css/type.css" type="text/css" media="all" charset="utf-8"/>
            <link rel="stylesheet" href="inc/docstyles.css" type="text/css" media="all" charset="utf-8"/>
        </head>
        <body>
            <nav class="navbar">
                <div class="app-name">API Client</div>
                <ul class="nav">
                    <li><a href="usagedoc.php">PHP API Client Doc</a></li>
                    <li class="active"><a href="apidoc.php">API Request Doc</a></li>
                    <li><a href="example/">API Playground</a></li>
                    <li><a href="https://github.com/aptoma/no.aptoma.drpublish.api.client.php" target="_blank">Download the API client from GitHub</a></li>
                </ul>
            </nav>

            <div class="doc-wrapper toc-depth-4">
            <h1>API querying <span style="font-size: 13px; font-style: italic; margin-left: 36px;">for use with DrLib 1 as the API engine</span></h1>
            <h2 class="no-sec">Table of contents</h2>
            	<ul class="toc"> </ul>

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
            </div>
            <script type="text/javascript">
            <xsl:text disable-output-escaping="yes"><![CDATA[
                (function ($) {
                    $(document).ready(function () {
                        var currentLevel;
                        var headerLevelCounts = [0, 0, 0, 0, 0];
                        var $toc = $('.toc');
                        $('h2, h3, h4, h5').not('.no-sec').each(function () {
                            var i;
                            currentLevel = this.nodeName.match(/H([2-6])/)[1] - 2;
                            headerLevelCounts[currentLevel]++;
                            for (i = 0; i < headerLevelCounts.length; i++) {
                                if (i > currentLevel) {
                                    headerLevelCounts[i] = 0;
                                }
                            }

                            $(this).html('<a href="#' + generateId(this) + '">' + $(this).html() + '</a>');
                            $toc.append(
                                $('<li>' + $(this).html() + '</li>').addClass('level-' + currentLevel)
                            );
                        });

                        function generateId(elem) {
                            if (!elem.id) {
                                elem.id = slugify($(elem).text()) + '-' + (1 + currentLevel) + '-' + headerLevelCounts[currentLevel];
                            }

                            return elem.id;
                        }

                        function slugify(text) {
                            return text.toLowerCase().replace(/[^a-z0-9]/g, '-');
                        }
                    });
                }(jQuery));
            ]]></xsl:text>
            </script>
       </body>
        </html>
	</xsl:template>
</xsl:stylesheet>
