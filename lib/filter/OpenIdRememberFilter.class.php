<?php
class OpenIdRememberFilter extends sfFilter
{
	public function execute($filterChain)
	{
		$context = $this->getContext();
		$request = $context->getRequest();
		$user = $context->getUser();

		// Execute this filter only once
		if ($this->isFirstCall() &&
			! $user->isAuthenticated() &&
			! $user->getAttribute('openid_triedAutoLog', false))
		{
			$user->setAttribute('openid_triedAutoLog', true);
			$cookie = $request->getCookie('openid_identity');
			if (!empty($cookie)) {
				$user->setReferer($request->getUri());
				$user->setAttribute('openid_identity', $cookie);
				return $context->getController()->forward('auth', 'autoSignin');
			}
		}

		// Execute next filter
		$filterChain->execute();
	}
}
