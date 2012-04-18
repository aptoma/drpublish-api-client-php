<?php

class DrPublishApiClientArticleElement
{

    protected $data;
    protected $medium;
    protected $dpClient;
    protected $dataType;

	public function __construct($data, $options)
	{
        $this->data = $data;
        $this->medium = $options->medium;
        //$this->dpClient = $options->dpClient;
        $this->dataType = $options->dataType;
	}

    function __toString()
    {
        return (string) $this->data;
    }

//	/**
//	 * Returns the entire content of the DOM node
//	 * @return string XML
//	 */
//	public function content()
//	{
//		// LIBXML_NOEMPTYTAG is for preventing empty tags in output generating
//		$xml = $this->dom->saveXml($this->domElement, LIBXML_NOEMPTYTAG);
//		$xhtml = preg_replace('!></(meta|link|base|basefont|param|img|br|hr|area|input)>!', ' />', $xml);
//		return $xhtml;
//	}
//
//	/**
//	 * Returns the inner content of the DOM node, without the requested node itself
//	 * @return string
//	 */
//	public function innerContent()
//	{
//		$xml = $this->content();
//		$matches = array();
//		// remove root tag
//		preg_match('/^(<[^>]*>)(.*)(<\/[^>]*>)$/s', $xml, $matches);
//		if (isset($matches[2])) {
//			return $matches[2];
//		}
//		// return empty string when tag is empty
//		$xml = preg_replace('/^(<[^\/>]*\/>)$/s', '', $xml);
//		return $xml;
//	}
//
//	/**
//	 * Gets the text content of the node, without any mark up
//	 * @return string
//	 */
//	public function textContent()
//	{
//		return strip_tags($this->content());
//	}
//
//	/**
//	 * Gets an attribute value from the DOM node
//	 * @param string $name
//	 * @return string
//	 */
//	public function getAttribute($name)
//	{
//		return $this->domElement->getAttribute($name);
//	}
//
//	/**
//	 * Sets an attribute value
//	 * @param string $name attribute name
//	 * @param string $value attribute value
//	 * @return void
//	 */
//	public function setAttribute($name, $value)
//	{
//		return $this->domElement->setAttribute($name, $value);
//	}
//
//	/**
//	 * Magic function to converting the node content to string using DrPublishApiClientArticleElement::innerContent()
//	 * @see DrPublishApiClientArticleElement::innerContent()
//	 * @return string
//	 */
//	public function __toString()
//	{
//		return $this->innerContent();
//	}
//
//	/**
//	 * Gets a list of article elements queried by XPath
//	 *
//	 * @see DrPublishClientArticleElement
//	 * @param string $xpathQuery XPath query
//	 * @return DrPublishClientArticleElementList
//	 */
//	public function getElements($xpathQuery)
//	{
////		print "<br/><br/>" . htmlentities($this->dom->saveXML($this->domElement));
//		$list = new DrPublishApiClientList();
////		print "<br/>$xpathQuery<br/>";
//		$domNodes = $this->xpath->query($xpathQuery, $this->domElement);
//		foreach ($domNodes as $domNode) {
//			$list->add(new DrPublishApiClientArticleElement($domNode, $this->dom, $this->dpClient, $this->xpath));
//		}
//		return $list;
//	}
//
//	/**
//	 * Gets one single article element queried by XPath. If multiple elements match the query, the first one will be returned
//	 * @param string $xpathQuery XPath query
//	 * @return DrPublishClientArticleElement | null
//	 */
//	public function getElement($xpathQuery)
//	{
//		$list = $this->getElements($xpathQuery);
//		if (empty($list)) {
//			return null;
//		}
//		return $list->first();
//	}

}
