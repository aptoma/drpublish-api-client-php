<?
abstract class DrPublishApiClientArticleEntity
{
    public function __construct($data) {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 3) === 'get') {
            $varName = lcfirst(substr($name, 3));
            if (isset($this->data->{$varName})) {
                return $this->data->{$varName};
            } else {
                return 'undefined';
            }
        }
    }

}