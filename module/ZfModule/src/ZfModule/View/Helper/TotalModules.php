<?php

namespace ZfModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfModule\Mapper;

class TotalModules extends AbstractHelper
{
    /**
     * @var Mapper\Module
     */
    private $moduleMapper;

    /**
     * @var int
     */
    private $total;

    /**
     * @param Mapper\Module $moduleMapper
     */
    public function __construct(Mapper\Module $moduleMapper)
    {
        $this->moduleMapper = $moduleMapper;
    }

    /**
     * @return int
     */
    public function __invoke()
    {
        if ($this->total === null) {
            $this->total = $this->moduleMapper->getTotal();
        }

        return $this->total;
    }
}
