<?php

namespace MFevola\SimplyEmail;

class Email
{

  /** @var string  */
  private $message;

  /** @var string  */
  private $subject;

  /** @var string  */
  private $from;

  /** @var string  */
  private $to;

  /** @var string  */
  private $headers;

  /** @var bool  */
  private $isHtml;

  /** @var string */
  private $replyTo;

  // TODO
  //$headers .= "CC: susan@example.com\r\n";
  public function __construct()
  {
    $this->message = "";
    $this->subject = "";
    $this->from    = "";
    $this->to      = "";
    $this->headers = "";
    $this->isHtml  = true;
    $this->replyTo = "";
  }

  /**
   * @param string $message
   * @return Email
   */
  public function setMessage($message)
  {
    $this->message = $message;

    return $this;
  }

  /**
   * @param string $subject
   * @return Email
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;

    return $this;
  }

  /**
   * @param string $from
   * @return Email
   */
  public function setFrom($from)
  {
    $this->from = $from;

    return $this;
  }

  /**
   * @param string $to
   * @return Email
   */
  public function setTo($to)
  {
    $this->to = $to;

    return $this;
  }

  /**
   * @param bool $isHtml
   * @return Email
   */
  public function setIsHtml($isHtml)
  {
    $this->isHtml = $isHtml;

    return $this;
  }

  /**
   * @return string
   */
  public function getReplyTo()
  {
    return $this->replyTo;
  }

  /**
   * @param string $replyTo
   * @return Email
   */
  public function setReplyTo($replyTo)
  {
    $this->replyTo = $replyTo;

    return $this;
  }

  public function send()
  {
    if (!$this->message)
    {
      throw new \Exception("Mail message not set");
    }
    if (!$this->subject)
    {
      throw new \Exception("Subject message not set");
    }
    if (!$this->to)
    {
      throw new \Exception("Recipient not set");
    }

    // Default from
    // TODO grab from config
    $from = "Johnny <jhonny@dep.com>";
    if (!empty($this->from))
    {
      $from = $this->from;
    }

    // It's very important not adding spaces in $headers
    $this->headers = "From: {$from}\r\n". "X-Mailer: php";

    if ($this->isHtml)
    {
      $this->headers .= "MIME-Version: 1.0\r\n";
      $this->headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    }

    if (!empty($this->replyTo))
    {
      $this->headers .= "Reply-To: ". strip_tags($this->replyTo) . "\r\n";
    }

    $isSent = mail(
      $this->to,
      $this->subject,
      $this->message,
      $this->headers
    );

    if (!$isSent)
    {
      throw new \Exception("Unable to send email!");
    }
  }



}
