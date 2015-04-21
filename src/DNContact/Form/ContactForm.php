<?php

namespace DNContact\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Description of UserForm
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactForm extends Form {

  public function __construct() {
    parent::__construct("contact-form", array("id" => "contact-form"));
    $this->setAttribute("class", "form-horizontal form-condensed");
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

  public function prepareElements() {
    $this->addText("name", _("Nom"))
            ->addText("subject", _("Objet"));
    $email = new \Zend\Form\Element\Email("email", [
        "label" => _("Adresse de messagerie"),
        "options" => [
            "messages" => [
                ""
            ]
        ]
    ]);
    $email->setEmailValidator(new \Zend\Validator\Regex([
        'pattern' => '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/',
        'messageTemplates' => [
            'regexNotMatch' => _("Votre email n'est pas valide. Il doit être du type contact@domain.ext")
        ]
    ]));
    $this->add($email);
    $textArea = new Textarea("body", ["label" => "Détails"]);
    $textArea->setAttributes(["rows" => "7", "maxlength" => 1500]);

    $submit = new Submit("send");
    $submit->setAttribute("class", "btn btn-primary pull-right");
    $submit->setValue(_("Envoyer"));
    $this->add($submit);

    $this->add($textArea);
    $this->add(new \Zend\Form\Element\Csrf('contact_csrf'));
  }

  protected function addInputFilter() {
    $inputFilter = $this->getInputFilter();
    $this->addFilter($inputFilter, "name", _("Vous devez spécifier votre nom"));
    $this->addFilter($inputFilter, "email", _("Vous devez spécifier votre adresse de messagerie"));
    $this->addFilter($inputFilter, "subject", _("Vous devez spécifier l'objet de votre message"));
    $this->addFilter($inputFilter, "body", _("Vous devez écrire un message"));
  }

  private function addFilter(\Zend\InputFilter\InputFilterInterface $inputFilter, $name, $emptyMessage) {
    $inputFilter->add([
        'name' => $name,
        'required' => true,
        'filters' => [
            ['name' => 'StringTrim', 'name' => 'HtmlEntities'],
        ],
        'validators' => [
            [
                'name' => 'NotEmpty',
                'options' => [
                    'messages' => ['isEmpty' => $emptyMessage],
                ],
            ],
        ],
    ]);
  }

  protected function addText($name, $label) {
    $this->add(new Text($name, array("label" => $label)));
    return $this;
  }

}
