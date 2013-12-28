<?php

namespace NpAppTest\Form;

use NpApp\Form\ContactFormInputFilterFactory;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-04-29 at 00:54:42.
 */
class ContactFormInputFilterFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContactFormInputFilterFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers NpApp\Form\ContactFormInputFilterFactory::newFilter
     * @todo   Implement testNewFilter().
     */
    public function testNewFilter()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    public function testNotEmptyValidator()
    {
        $options = array(
            'type' => \Zend\Validator\NotEmpty::STRING, 
            'translatorEnabled' => true,
            'messages' => array(
                \Zend\Validator\NotEmpty::IS_EMPTY => "お名前を入力してください",
                \Zend\Validator\NotEmpty::INVALID  => "Invalid type given. String, integer, float, boolean or array expected",
            ),
        );
        $validator = new \Zend\Validator\NotEmpty($options);
        $this->assertFalse($validator->isValid('')); //good
        $this->assertEquals($options['messages'], $validator->getMessageTemplates());
        
        $validator = new \Zend\Validator\NotEmpty(array('translatorEnabled' => true));
        $this->assertEquals(493, $validator->getType());
        $this->assertFalse($validator->isValid('')); //Failed asserting that true is false.
        
        $validator = new \Zend\Validator\NotEmpty(array('translatorEnabled' => false));
        $this->assertFalse($validator->isValid(''));//good
        
        $validator = new \Zend\Validator\NotEmpty();
        $this->assertFalse($validator->isValid(''));//good
        
        $validator->setTranslatorEnabled(true);
        $this->assertFalse($validator->isValid(''));//good
    }
    
    public function testInputFilterDef()
    {
        $inputFilter = new \Zend\InputFilter\InputFilter;
        $def = array(
            'name' => 'bug',
            //'required' => true,
            'validators' => array(
                array(
                    'name' => 'notempty',
                    'options' => array('translatorEnabled' => true),
                ),
            ),
        );
        $inputFilter->add($def);
        $inputFilter->setData(array());
        $this->assertFalse($inputFilter->isValid());
        
        
    }

    /**
     * @covers NpApp\Form\ContactFormInputFilterFactory::addFilters
     */
    public function testAddFilters()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $this->assertInstanceof('Zend\InputFilter\InputFilterInterface', $inputFilter);
    }
    
    public function testHasNameField()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $this->assertTrue($inputFilter->has('name'));
        $name = $inputFilter->get('name');
        $this->assertInstanceof('Zend\InputFilter\InputInterface', $name);
        return $inputFilter;
    }
    
    public function testNameFieldNotAllowEmpty()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $this->assertTrue($inputFilter->has('name'));
        $name = $inputFilter->get('name');
        $this->assertFalse($name->allowEmpty());
    }
    
    public function testNameFieldIsRequired()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $this->assertTrue($inputFilter->has('name'));
        $name = $inputFilter->get('name');
        $this->assertTrue($name->isRequired());
    }
    
    public function testNameFieldHasNotEmptyValidator()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $validatorChain = $inputFilter->get('name')->getValidatorChain();
        $this->assertInstanceof('Zend\Validator\ValidatorChain', $validatorChain);
        $validators = $validatorChain->getValidators();
        $this->assertCount(1, $validators);
        $validator = reset($validators);
        $this->assertInstanceof('Zend\Validator\NotEmpty', $validator['instance']);
    }
    
    public function testInvalidData()
    {
        $inputFilter = ContactFormInputFilterFactory::addFilters();
        $inputFilter->setData(['foo' => 'bar']);
        
        $valid = $inputFilter->isValid();
        
        $this->assertFalse($valid);
        
        $name = $inputFilter->get('name');
        if ($name->isValid()) {
            error_log('value is : ' . var_export($name->getValue(), true));
        }
        
    }
}
