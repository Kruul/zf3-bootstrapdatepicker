<?php

namespace User\View\Helper;

use EdpGithub\Client;
use Zend\View\Helper\AbstractHelper;

class UserOrganizations extends AbstractHelper
{
    /**
     * @var Client
     */
    private $githubClient;

    /**
     * $var string template used for view
     */
    protected $viewTemplate;

    /**
     * @param Client $githubClient
     */
    public function __construct(Client $githubClient)
    {
        $this->githubClient = $githubClient;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        $orgs = $this->githubClient->api('current_user')->orgs();

        return $this->getView()->render('user/helper/user-organizations.phtml', [
            'orgs' => $orgs,
        ]);
    }
}
