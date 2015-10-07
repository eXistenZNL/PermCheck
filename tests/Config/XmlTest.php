<?php

use eXistenZNL\PermCheck\Config\Config;
use eXistenZNL\PermCheck\Config\Loader\Xml;

class XmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Xml
     */
    protected $xml;

    public function setUp()
    {
        $config = new Config();
        $this->xml = new Xml();
        $this->xml->setConfig($config);
    }

    public function tearDown()
    {
        unset($this->xml);
    }

    /**
     * @dataProvider brokenXmlProvider
     * @expectedException \RuntimeException
     */
    public function testIfLoadingABrokenXmlFails($xml)
    {
        $this->xml->setData($xml);
        $data = $this->xml->parse();
    }

    /**
     * @dataProvider correctXmlProvider
     */
    public function testIfLoadingACorrectXmlWorks($xml)
    {
        $this->xml->setData($xml);
        $data = $this->xml->parse();
    }

    /**
     * @dataProvider excludesProvider
     */
    public function testIfExcludesAreReadFromTheConfig($xml, $data)
    {
        $this->xml->setData($xml);
        $config = $this->xml->parse();

        $this->assertEquals($config['excludes'], $data);
    }

    public function brokenXmlProvider()
    {
        return array(
            array(345),
            array(null),
            array(false),
            array(array()),
            array(''),
            array('<xml></xml>'),
            array('<permcheck></permcheck>')
        );
    }

    public function correctXmlProvider()
    {
        return array(
            array('<permcheck><excludes /><executables/></permcheck>'),
            array('<permcheck><excludes><file>bladi</file></excludes><executables/></permcheck>'),
        );
    }

    public function excludesProvider()
    {
        return array(
            array(
                '<permcheck>
                    <excludes>
                        <file>files/file1.php</file>
                        <file>files/file2.css</file>
                    </excludes>
                    <executables/>
                </permcheck>',
                array(
                    'files/file1.php',
                    'files/file2.css',
                ),
            ),
            array(
                '<permcheck>
                    <excludes>
                        <file>files/file3.sh</file>
                    </excludes>
                    <executables/>
                </permcheck>',
                array(
                    'files/file3.sh',
                ),
            ),
        );
    }
}
