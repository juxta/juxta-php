<?php namespace Juxta\Exception;

trait ExceptionAttachTrait
{
    /**
     * @var mixed
     */
    private $attachment;

    /**
     * {@inheritdoc}
     */
    public function attach($object)
    {
        $this->attachment = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachment()
    {
        return $this->attachment;
    }
}