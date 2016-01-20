<?php

namespace DNContact\Controller;

use DNContact\Form\ContactForm;
use DNContact\Options\MapOptionsInterface;
use DNContact\Options\ModuleOptions;
use DNContact\Service\AdminMailService;
use Zend\Filter\StripNewlines;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{

    /** @var ModuleOptions */
    private $options;

    /** @var MapOptionsInterface */
    private $mapOptions;

    /** @var AdminMailService */
    private $mailService;

    /** @var ContactForm */
    protected $form;

    public function __construct(AdminMailService $mailService, ContactForm $form, MapOptionsInterface $mapOptions)
    {
        $this->mailService = $mailService;
        $this->form = $form;
        $this->mapOptions = $mapOptions;
    }

    /**
     * @return ModuleOptions
     */
    private function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->getServiceLocator()->get("dncontact_module_options");
        }
        return $this->options;
    }

    public function contactAction()
    {
        $form = $this->form;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->sendMessage($form);
                return $this->redirect()->toRoute($this->getOptions()->getRedirectRoute());
            }
        }
//      FOR Testing
//    $form->setData([
//        "name" => "Nicolas Desprez",
//        "email" => "captainnord@msn.com",
//        "user_role" => "Chantier Naval",
//        "subject" => "Sujet du message",
//        "body" => str_repeat("C'est un message test envoyé depuis le controller ContactController en php !", 10),
//    ]);
        $options = $this->getOptions();
        $view = new ViewModel();
        $view->setVariable("address", $options->getAddress());
        $view->setVariable("useGmap", $options->getUseGmap());
        $filter = new StripNewlines();
        if ($options->getUseGmap()) {
            $mapOptions = $this->mapOptions;
            $view->setVariable("gmapInfoHtml", $filter->filter($mapOptions->getInfo()));
            $view->setVariable("gmapOptions", json_encode($mapOptions->getOptions(), JSON_NUMERIC_CHECK));
            $view->setVariable("gmapCenter", $mapOptions->getCenter());
        }
        $view->setVariable("form", $form);
        return $view;
    }

    private function sendMessage(ContactForm $form)
    {
        $this->mailService->hydrate($form);
        $translator = $this->getServiceLocator()->get('translator');
        try {
            $this->mailService->send();
            $message = $translator->translate($this->getOptions()->getSuccessMessage());
            $this->flashMessenger()->addSuccessMessage($message);
        } catch (\Exception $exc) {
            throw new \DNContact\ContactException($translator->translate("Une erreure est apparue pendant l'envoi du message :( Veuillez réessayer"), 400, $exc);
        }
    }

}
