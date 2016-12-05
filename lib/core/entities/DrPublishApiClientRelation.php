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
        $this->subjectId = $this->subject_id;
        $this->objectId = $this->object_id;
    }

    public function __toString()
    {
        return isset($this->$relationship) ? $this->$relationship : '';
    }
}
