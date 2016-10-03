<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zf3\Bootstrapdatepicker;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
return array(
    'router' => array(
        'routes' => array(

            'bootsrap-datapicker' => array(
                'type'    => Segment::class,
                'options' => array(
                    'route'    => '/bootsrap/datapicker[/:action][/:lang]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'lang'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'    => Controller\DatepickerController::class,
                        'action'        => 'index',
                    ),
                ),

            ),
        ),
    ),

    'controllers' => array(
        'factories' => [
            Controller\DatepickerController::class => InvokableFactory::class,
        ],
    ),
    'view_manager' => array(

        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

