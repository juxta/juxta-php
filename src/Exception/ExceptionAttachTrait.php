<?php namespace Juxta\Exception;

trait ExceptionAttachTrait
{
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