<?php
/**
 * Created by PhpStorm.
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */

namespace DNContactTest\Form;
use DNContact\Form\ContactForm;
use DNContact\Options\FormOptions;
use DNContactTest\Bootstrap;
use Zend\Form\Form;


/**
 * Class ContactFormTest
 * @author Nicolas Desprez <contact@dnconcept.fr>
 * @package DNContactTest\Form
 */
class ContactFormTest extends \PHPUnit_Framework_TestCase
{

    /** @var  Form */
    private $form;

    protected function setUp(){
        $this->form = Bootstrap::getServiceManager()->get('dncontact_form');
    }

    public function testHasFields()
    {
        foreach (["name", "subject", "email", "body", "send"] as $field) {
            $this->assertTrue($this->form->has($field));
        }
    }

}