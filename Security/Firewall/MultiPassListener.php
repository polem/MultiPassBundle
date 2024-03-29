<?php

namespace Polem\MultiPassBundle\Security\Firewall;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\SecurityContextInterface,
    Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface,
    Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface,
    Symfony\Component\Security\Http\HttpUtils,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\HttpKernel\Log\LoggerInterface,
    Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use Polem\MultiPassBundle\Security\Authentication\Token\MultiPassToken;
    MultiPass\Configuration;

class MultiPassListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    protected $strategy;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, SessionAuthenticationStrategyInterface $sessionStrategy, HttpUtils $httpUtils, $providerKey, array $options = array(), AuthenticationSuccessHandlerInterface $successHandler = null, AuthenticationFailureHandlerInterface $failureHandler = null, LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null, MultiPass\Strategy $strategy)
    {
        parent::__construct($securityContext, $authenticationManager, $sessionStrategy, $httpUtils, $providerKey, $options, $successHandler, $failureHandler, $logger, $dispatcher);
        $strategy->configure($options);
        $this->strategy = $strategy;
        $this->httpUtils = $httpUtils;
    }

    protected function requiresAuthentication(Request $request)
    {
        if ( $this->httpUtils->checkRequestPath($request, $this->options['check_path'])
            || $this->httpUtils->checkRequestPath($request, $this->options['login_path'])
        ) {
            return true;
        }
        return false;
    }

    protected function attemptAuthentication(Request $request)
    {
        if ($this->httpUtils->checkRequestPath($request, $this->options['login_path'])) {
            $strategy->requestPhase();
        }

        $token = new MultiPassToken();
        $token->authHash = $strategy->callbackPhase();

        return $this->authenticationManager->authenticate($token);
    }
}
