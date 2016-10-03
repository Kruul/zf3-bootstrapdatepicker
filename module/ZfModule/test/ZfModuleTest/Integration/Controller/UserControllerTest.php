<?php

namespace ZfModuleTest\Integration\Controller;

use ApplicationTest\Integration\Util\Bootstrap;
use Zend\Http;
use Zend\Paginator;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use ZfModule\Controller;
use ZfModule\Mapper;

class UserControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->setApplicationConfig(Bootstrap::getConfig());
    }

    public function testUserPageCanBeAccessed()
    {
        $userName = 'gianarb';

        $moduleMapper = $this->getMockBuilder(Mapper\Module::class)->getMock();

        $moduleMapper
            ->expects($this->once())
            ->method('pagination')
            ->with(
                $this->equalTo(1),
                $this->equalTo(10),
                $this->equalTo($userName),
                $this->equalTo('created_at'),
                $this->equalTo('DESC')
            )
            ->willReturn(new Paginator\Paginator(new Paginator\Adapter\NullFill()))
        ;

        $moduleMapper
            ->expects($this->any())
            ->method('findAll')
            ->with($this->anything())
            ->willReturn([])
        ;

        $this->getApplicationServiceLocator()
            ->setAllowOverride(true)
            ->setService(
                Mapper\Module::class,
                $moduleMapper
            )
        ;

        $url = sprintf(
            '/user/%s',
            $userName
        );

        $this->dispatch($url);

        $this->assertMatchedRouteName('modules-for-user');

        $this->assertControllerName(Controller\UserController::class);
        $this->assertActionName('modulesForUser');
        $this->assertResponseStatusCode(Http\Response::STATUS_CODE_200);
    }
}
