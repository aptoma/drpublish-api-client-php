<?php
/**
 * DrPublishApiClientArticleElement.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientArticleElement represents a DOM node
 * The class provides methods for acessing element attributes and converting the element content to string
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see DOMDocument
 * @see DOMElement
 * @see DOMXpath
 */
class DrPublishApiClientArticleElement
{
	protected $domElement;
	protected $dom;
	protected $xpath;
	protected $dpClient;

	/**
	 * The class constructor registers the DOMElement and the entire related DOMDocument (needed for the to-string methods)
	 * @param DOMElement $domElement
	 * @param DOMDocument $dom
	 * @param DrPublishApiClient $dpClient
	 * @return void
	 */
	public function __construct(DOMElement $domElement, DOMDocument $dom, DrPublishApiClient $dpClient, DOMXPath $xpath)
	{
		$this->domElement = $domElement;
		$this->dom = $dom;
		$this->dpClient = $dpClient;
		$this->xpath = $xpath;
	}

	/**
	 * Returns the entire content of the DOM node
	 * @return string XML
	 */
	public function content()
	{
		// LIBXML_NOEMPTYTAG is for preventing empty tags in output generating 
		$xml = $this->dom->saveXml($this->domElement, LIBXML_NOEMPTYTAG);
		$xhtml = preg_replace('!></(meta|link|base|basefont|param|img|br|hr|area|input)>!', ' />', $xml);
		return $xhtml;
	}

	/**
	 * Returns the inner content of the DOM node, without the requested node itself
	 * @return string
	 */
	public function innerContent()
	{
		$xml = $this->content();
		$matches = array();
		// remove root tag
		preg_match('/^(<[^>]*>)(.*)(<\/[^>]*>)$/s', $xml, $matches);
		if (isset($matches[2])) {
			return $matches[2];
		}
		// return empty string when tag is empty
		$xml = preg_replace('/^(<[^\/>]*\/>)$/s', '', $xml);
		return $xml;
	}

	/**
	 * Gets the text content of the node, without any mark up
	 * @return string
	 */
	public function textContent()
	{
		return strip_tags($this->content());
	}

	/**
	 * Gets an attribute value from the DOM node
	 * @param string $name
	 * @return string
	 */
	public function getAttribute($name)
	{
		return $this->domElement->getAttribute($name);
	}

	/**
	 * Sets an attribute value
	 * @param string $name attribute name
	 * @param string $value attribute value
	 * @return void
	 */
	public function setAttribute($name, $value)
	{
		return $this->domElement->setAttribute($name, $value);
	}

	/**
	 * Magic function to converting the node content to string using DrPublishApiClientArticleElement::innerContent()
	 * @see DrPublishApiClientArticleElement::innerContent()
	 * @return string
	 */
	public function __toString()
	{
		return $this->innerContent();
	}
	
	/**
	 * Gets a list of article elements queried by XPath
	 *
	 * @see DrPublishClientArticleElement
	 * @param string $xpathQuery XPath query
	 * @return DrPublishClientArticleElementList
	 */
	public function getElements($xpathQuery)
	{
//		print "<br/><br/>" . htmlentities($this->dom->saveXML($this->domElement));
		$list = new DrPublishApiClientList();
//		print "<br/>$xpathQuery<br/>";
		$domNodes = $this->xpath->query($xpathQuery, $this->domElement);
		foreach ($domNodes as $domNode) {
			$list->add(new DrPublishApiClientArticleElement($domNode, $this->dom, $this->dpClient, $this->xpath));
		}
		return $list;		
	}
	
	/**
	 * Gets one single article element queried by XPath. If multiple elements match the query, the first one will be returned
	 * @param string $xpathQuery XPath query
	 * @return DrPublishClientArticleElement | null
	 */
	public function getElement($xpathQuery)
	{
		$list = $this->getElements($xpathQuery);
		if (empty($list)) {
			return null;
		}
		return $list->first();
	}

}
