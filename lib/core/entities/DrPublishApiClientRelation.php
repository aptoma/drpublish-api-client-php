<?php
class DrPublishApiClientRelation extends DrPublishApiClientArticleEntity
{
    protected $object;
    protected $objectId;
    protected $relationship;
    protected $relationshipPriority;
    protected $subject;
    protected $subjectId;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->relationshipPriority = $this->relationship_priority;
    }

    public function __toString()
    {
        return isset($this->$relationship) ? $this->$relationship : '';
    }
}
