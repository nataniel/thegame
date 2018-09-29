<?php
namespace Main\Model\Mailer;

use Zend\Mail;
use Zend\Mime;

/**
 * @Entity
 * @Table(name="mailer_templates")
 */
class Template extends \E4u\Model\Entity
{
    const FORMAT_TXT = 1;
    const FORMAT_HTML = 2;

    /** @Column(type="string") */
    protected $name;

    /** @Column(type="string") */
    protected $description = '';

    /** @Column(type="string") */
    protected $from_name;

    /** @Column(type="string") */
    protected $from_email;

    /** @Column(type="string") */
    protected $to_name = '';

    /** @Column(type="string") */
    protected $to_email;

    /** @Column(type="text") */
    protected $headers = '';

    /** @Column(type="string") */
    protected $subject = '';

    /** @Column(type="text") */
    protected $content = '';

    /** @Column(type="smallint") */
    protected $format = self::FORMAT_TXT;

    /** @Column(type="string", length=5) */
    protected $locale = 'pl';

    protected $attachments = [];

    /**
     * @var Mail\Transport\TransportInterface
     */
    protected $mailer;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->from_name;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->from_email;
    }

    /**
     * @return string
     */
    public function getToName()
    {
        return $this->to_name;
    }

    /**
     * @return string
     */
    public function getToEmail()
    {
        return $this->to_email;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return Mail\Transport\TransportInterface
     */
    public function getMailer()
    {
        if (null === $this->mailer) {
            $this->mailer = \E4u\Loader::getMailer();
        }

        return $this->mailer;
    }

    /**
     * @param Mail\Transport\TransportInterface $mailer
     * @return $this
     */
    public function setMailer(Mail\Transport\TransportInterface $mailer)
    {
        $this->mailer = $mailer;
        return $this;
    }

    /**
     * @param array $vars
     * @return Mail\Message
     */
    public function prepare($vars = null)
    {
        $message = new Mail\Message();
        $options = [
            'headers'  => $this->getHeaders(),
            'from_name' => $this->getFromName(),
            'from_email' => $this->getFromEmail(),
            'to_name' => $this->getToName(),
            'to_email' => $this->getToEmail(),
            'subject' => $this->getSubject(),
            'body' => $this->getContent(),
        ];

        foreach ($options as $key => $value) {
            $options[$key] = \E4u\Common\Template::merge($value, $vars);
        }

        $headers = Mail\Headers::fromString($options['headers']);
        $headers->addHeader(Mail\Header\ContentType::fromString('Content-Type: text/plain; charset=utf-8'));

        $text = new Mime\Part($options['body']);
        $text->type = Mime\Mime::TYPE_TEXT;
        $text->charset = 'utf-8';

        $parts = [ $text ];
        foreach ($this->attachments as $attachment) {
            $parts[] = $attachment;
        }

        $mimeMessage = new Mime\Message();
        $mimeMessage->setParts($parts);

        $message->setEncoding('utf-8')
            ->setHeaders($headers)
            ->setFrom($options['from_email'], $options['from_name'])
            ->setTo($options['to_email'], $options['to_name'])
            ->setSubject($options['subject'])
            ->setBody($mimeMessage);
        return $message;
    }

    private function addAttachment($filename, $mimeType = null)
    {
        if (!is_string($mimeType)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filename);
            finfo_close($finfo);
        }

        $attachment = new Mime\Part(fopen($filename, 'r'));
        $attachment->type = $mimeType;
        $attachment->filename = basename($filename);
        $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
        $attachment->encoding = Mime\Mime::ENCODING_BASE64;

        $this->attachments[] = $attachment;
        return $this;
    }

    /**
     * @param  string[] $attachments
     * @return $this
     */
    public function setAttachments($attachments = [])
    {
        $this->attachments = [];
        foreach ($attachments as $key => $value) {

            if (is_string($key)) {
                $this->addAttachment($key, $value);
            }
            elseif (is_int($key)) {
                $this->addAttachment($value);
            }

        }

        return $this;
    }

    /**
     * @param array $vars
     * @return Template Current instance
     */
    public function send($vars = null)
    {
        $message = $this->prepare($vars);
        if ($message->isValid()) {
            $this->getMailer()->send($message);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $locale
     * @return Template|FALSE
     */
    public static function load($name, $locale = null)
    {
        if (null === $locale) {
            return self::findOneBy([ 'name' => $name ], [ 'locale' => 'DESC' ]);
        }

        $result = self::findOneBy([ 'name' => $name, 'locale' => $locale ]);
        if (!empty($result)) {
            return $result;
        }

        $result = self::findOneBy([ 'name' => $name, 'locale' => null ]);
        if (!empty($result)) {
            return $result;
        }

        return false;
    }

    /**
     *
     * @param string $name
     * @param array  $vars
     * @param string $locale
     */
    public static function sendTemplate($name, $vars = null, $locale = null)
    {
        if ($template = self::load($name, $locale)) {
            $template->send($vars);
        }
    }
}