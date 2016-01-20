<?php

namespace DNContact\Form;

use DNContact\Options\FormOptions;
use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;

/**
 * Description of ContactForm
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactForm extends Form
{
    /** @var FormOptions */
    private $formOptions;

    public function __construct(FormOptions $formOptions)
    {
        parent::__construct("contact-form", array("id" => "contact-form"));
        $this->formOptions = $formOptions;
        $this->setAttribute("class", "form-horizontal");
        $this->prepareElements();
        $this->addInputFilter();
        foreach ($this as $element) {
            if ($element instanceof Submit || $element instanceof Button) {
                continue;
            }
            $element->setAttribute("placeholder", $element->getLabel());
            $element->setAttribute("class", "form-control");

            $element->setLabelAttributes(array("class" => "control-label col-sm-3"));
        }
    }

    public function prepareElements()
    {
        $this->addText("name", _("Nom"))
            ->addText("subject", _("Objet de votre message"));
        $email = new Email("email", [
            "label" => _("Adresse de messagerie"),
        ]);
        $email->setEmailValidator(new EmailAddress());
        $this->add($email);
        $textArea = new Textarea("body", ["label" => _("Message")]);
        $textArea->setAttributes([
            "rows" => "7",
            //For javascript use (jquery Validate)
            "data-rule-required" => "true",
            "data-rule-minlength" => $this->formOptions->getMinLength(),
            "data-rule-maxlength" => $this->formOptions->getMaxLength(),
        ]);

        $submit = new Submit("send");
        $submit->setAttribute("class", "btn btn-primary pull-right");
        $submit->setValue(_("Envoyer"));
        $this->add($submit);

        $this->add($textArea);
//        $this->add(new Csrf('contact_csrf'));
        //TODO Understand CSRF for form contacts
    }

    protected function addInputFilter()
    {
        $inputFilter = $this->getInputFilter();
        $this->addFilter($inputFilter, "name", _("Vous devez spécifier votre nom"));
        $this->addFilter($inputFilter, "email", _("Vous devez spécifier votre adresse de messagerie"));
        $this->addFilter($inputFilter, "subject", _("Vous devez spécifier l'objet de votre message"));
        $this->addFilter($inputFilter, "body", [
            [
                'name' => 'NotEmpty',
                'options' => [
                    'messages' => ['isEmpty' => _("Vous devez écrire un message")],
                ],
            ],
            [
                'name' => 'StringLength',
                'options' => [
                    'min' => $this->formOptions->getMinLength(),
                    'max' => $this->formOptions->getMaxLength(),
                ],
            ]
        ]);
    }

    /**
     *
     * @param InputFilterInterface $inputFilter
     * @param string $name Name of filter
     * @param string|array $emptyMessage Empty message or Validators array
     * @return InputFilterInterface
     */
    private function addFilter(InputFilterInterface $inputFilter, $name, $emptyMessage)
    {
        if (is_array($emptyMessage)) {
            $validators = $emptyMessage;
        } else {
            $validators = [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => ['isEmpty' => $emptyMessage],
                    ],
                ],
            ];
        }
        return $inputFilter->add([
            'name' => $name,
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim', 'name' => 'HtmlEntities'],
            ],
            'validators' => $validators,
        ]);
    }

    protected function addText($name, $label)
    {
        return $this->add(new Text($name, ["label" => $label]));
    }

}
