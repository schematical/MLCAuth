<?php
abstract class MLCAuthTrigger{
	const UserSignup = 'mlc_auth_usersignup';
}

abstract class MLCAuthQS{
    const email = 'email';
    const password = 'password';
    const session = 'session';
    const invite_token = 'mlcauthtoken';
}