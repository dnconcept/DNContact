<?php

namespace DNContact\Service;

use DNContact\Options\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\Form;
use Zend\Mail\Address;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Validator\EmailAddress;
use Zend\Mime;

/**
 * Description of AdminMailService
 *
 * Ce service permet d'envoyer des mails à l'administrateur du site internet
 *
 * Il gère 2 événements  : 'beforeSend', 'afterSend'
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class AdminMailService implements EventManagerAwareInterface, ServiceLocatorAwareInterface
{

    const BEFORE_SEND = 'before.send';
    const AFTER_SEND = 'after.send';
    const AFTER_HYDRATE = 'after.hydrate';
    const BEFORE_RENDER = 'before.render';

    /** @var EventManagerInterface */
    protected $events;

    /** @var TransportInterface */
    private $transport;

    /** @var Message */
    private $message;

    /** @var \Zend\View\Model\ViewModel */
    private $model;

    /** @var \Zend\ServiceManager\ServiceLocatorInterface */
    private $sm;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_class($this)
        ));
        $this->events = $events;
    }

    public function getEventManager()
    {
        if (!$this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function getServiceLocator()
    {
        return $this->sm;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator;
        return $this;
    }

    /**
     * @param TransportInterface $transport
     * @param ModuleOptions $options
     * @throws \DNContact\ContactException
     */
    public function __construct(TransportInterface $transport, ModuleOptions $options)
    {
        $this->transport = $transport;
        $this->initAdminMessage($options->getAdminMail(), $options->getAdminName());
    }

    /**
     * Initialize the message for administrator
     * @param string $adminMail
     * @param string $adminName
     * @throws \DNContact\ContactException
     */
    private function initAdminMessage($adminMail, $adminName)
    {
        $mail = $this->message = new Message();
        $emailValidator = new EmailAddress();
        if (!$emailValidator->isValid($adminMail)) {
            throw new \DNContact\ContactException("The config for administrator mail is not set correctly : " . implode(PHP_EOL, $emailValidator->getMessages()));
        }
        $mail->addTo(new Address($adminMail, $adminName));
    }

    /**
     * @param Form $form
     */
    public function hydrate(Form $form)
    {
        //Réinitialisation de la vue
        $this->model = null;
        $data = $form->getData();
        $fromAddress = new Address($data["email"], $data["name"]);
        $subject = $data["subject"];
        $bodyText = $data["body"];
        $this->createHtmlMessage($data, $fromAddress, $subject, $bodyText);
        $this->getEventManager()->trigger(self::AFTER_HYDRATE, $this, [
            "data" => $form->getData(),
            "model" => $this->getViewModel(),
            "message" => $this->message
        ]);
    }

    /**
     * @param array $data
     * @param \Zend\Mail\Address\AddressInterface $fromAddress
     * @param string $subject
     * @param string $content
     * @return Message
     */
    private function createHtmlMessage(array $data, Address\AddressInterface $fromAddress, $subject, $content)
    {
        $renderer = $this->getRenderer();
        $model = $this->getViewModel();
        $model->setVariable('name', $fromAddress->getName());
        $model->setVariable('email', $fromAddress->getEmail());
        $model->setVariable('content', $content);

        $this->getEventManager()->trigger(self::BEFORE_RENDER, $this, [
            "data" => $data,
            "model" => $model,
            "message" => $this->message
        ]);

        //Generate HTML message
        $model->setTemplate('mails/html');
        $bodyHtml = $renderer->render($model);

        //Generate text message
        $model->setTemplate('mails/text');
        $bodyText = $renderer->render($model);

        $mail = $this->message;

        $mail->setFrom($fromAddress);
        $mail->setSubject($subject);

        $html = new Mime\Part($bodyHtml);
        $html->type = Mime\Mime::TYPE_HTML; // 'text/html';
        $html->disposition = Mime\Mime::DISPOSITION_INLINE;
        $html->encoding = Mime\Mime::ENCODING_BASE64;
        $html->charset = 'UTF-8';

        $text = new Mime\Part($bodyText);
        $text->type = Mime\Mime::TYPE_TEXT; //  'text/plain';
        $text->disposition = Mime\Mime::DISPOSITION_INLINE;
        $text->encoding = Mime\Mime::ENCODING_BASE64;
        $text->charset = 'UTF-8';

        $body = new Mime\Message();
        $body->addPart($text);
        $body->addPart($html);
        $mail->setBody($body);
        $mail->setEncoding('UTF-8');

        $headers = $mail->getHeaders();
        $headers->get('content-type')->setType('multipart/alternative');
        return $mail;
    }

    private function getViewModel()
    {
        if (!$this->model) {
            $this->model = new \Zend\View\Model\ViewModel();
        }
        return $this->model;
    }

    /**
     *
     * @return \Zend\View\Renderer\PhpRenderer
     */
    private function getRenderer()
    {
        return $this->getServiceLocator()->get("viewrenderer");
    }

    public function send()
    {
        //On déclenche l'événement BEFORE_SEND
        $this->getEventManager()->trigger(self::BEFORE_SEND, $this, ["message" => $this->message]);
        //On envoie le message
        $this->transport->send($this->message);
        //On déclenche l'événement AFTER_SEND
        $this->getEventManager()->trigger(self::AFTER_SEND, $this, ["message" => $this->message]);
    }

    /**
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Get the message
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

}
