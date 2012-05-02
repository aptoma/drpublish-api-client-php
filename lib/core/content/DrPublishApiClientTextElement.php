<?
class DrPublishApiClientTextElement extends DrPublishApiClientArticleElement
{
    function __toString()
    {
        return $this->content();
    }

    public function content()
    {
       return (string)$this->data;
    }

    public function innerContent()
    {
       return $this->content();
    }

    public function html()
    {
        return $this->content();
    }

    public function innerHtml()
    {
        return $this->innerContent();
    }

}