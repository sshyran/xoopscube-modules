<?php
interface Sabai_Form_Validator_Interface
{
    /**
     * @return bool
     * @param Sabai_Form $form
     */
    public function validate(Sabai_Form $form){}
}