<?php

namespace MFevola\SimplyEmail;

/**
 * Class Email
 * @package MFevola\SimplyEmail
 */
class Email
{
  /** @var Config */
  private $config;

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

  /** @var string */
  private $cc;

  /**
   * Email constructor.
   */
  public function __construct()
  {
    $config= (new Config())->getData();
    $this->from    = array_key_exists("from", $config) ? $config["from"] : "";
    $this->to      = array_key_exists("to", $config) ? $config["to"] : "";
    $this->cc      = array_key_exists("cc", $config) ? $config["cc"] : "";;
    $this->replyTo = array_key_exists("replyTo", $config) ? $config["replyTo"] : "";;
    $this->isHtml  = array_key_exists("isHtml", $config) ? $config["isHtml"] : false;
    $this->subject = array_key_exists("subject", $config) ? $config["subject"] : "";;
    $this->headers = "";
    $this->message = "";
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
    if (empty($this->message))
    {
      throw new \Exception("Missing \"message\" value");
    }
    if (empty($this->subject))
    {
      throw new \Exception("Missing \"subject\" value");
    }
    if (empty($this->to))
    {
      throw new \Exception("Missing \"recipient\" value");
    }

    // It's very important not adding spaces in $headers
    $this->headers = sprintf(
      "From: %s\r\n%s",
      $this->from,
      "X-Mailer: php"
    );

    if ($this->isHtml)
    {
      $this->headers .= "MIME-Version: 1.0\r\n";
      $this->headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    }

    if (!empty($this->replyTo))
    {
      $this->headers .= "Reply-To: ". strip_tags($this->replyTo) . "\r\n";
    }

    $carbonCopy = $this->cc;
    if (is_array($carbonCopy))
    {
      $carbonCopy = implode(", ", $carbonCopy);
    }

    if (!empty($this->cc))
    {
      $this->headers .= "CC: ". $this->cc . "\r\n";
    }

    $recipients = $this->to;
    if (is_array($recipients))
    {
      $recipients = implode(", ", $recipients);
    }

    $isSent = mail(
      $recipients,
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
