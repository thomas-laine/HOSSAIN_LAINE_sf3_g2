<?php

namespace AppBundle\Antispam;


class Antispam
{

    private $antispamLength;

    private $mailer;

    public function __construct($antispamLength, \Swift_Mailer $mailer)
    {
        $this->antispamLength = $antispamLength;
        $this->mailer = $mailer;
    }
    
    public function isSpam($text)
    {
        return strlen($text) > $this->antispamLength;
    }
}