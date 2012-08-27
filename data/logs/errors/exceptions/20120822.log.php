<?php exit('Forbidden'); ?>
[2012-08-22 13:43:14] (PDOException) Exception PDOException: SQLSTATE[28000] [1045] Access denied for user 'ragnarok'@'localhost' (using password: YES)
[2012-08-22 13:43:14] (PDOException) **TRACE** #0 G:\wamp\www\cpf\lib\Flux\Connection.php(81): PDO->__construct('mysql:host=127....', 'ragnarok', 'ragnarok', Array)
[2012-08-22 13:43:14] (PDOException) **TRACE** #1 G:\wamp\www\cpf\lib\Flux\Connection.php(94): Flux_Connection->connect(Object(Flux_Config))
[2012-08-22 13:43:14] (PDOException) **TRACE** #2 G:\wamp\www\cpf\lib\Flux\Connection.php(159): Flux_Connection->getConnection()
[2012-08-22 13:43:14] (PDOException) **TRACE** #3 G:\wamp\www\cpf\lib\Flux\LoginServer.php(587): Flux_Connection->getStatement('SELECT list FRO...')
[2012-08-22 13:43:14] (PDOException) **TRACE** #4 G:\wamp\www\cpf\lib\Flux\SessionData.php(262): Flux_LoginServer->isIpBanned()
[2012-08-22 13:43:14] (PDOException) **TRACE** #5 G:\wamp\www\cpf\modules\account\login.php(19): Flux_SessionData->login('FluxRO', 'megasantos', 'lmdo030593', NULL)
[2012-08-22 13:43:14] (PDOException) **TRACE** #6 G:\wamp\www\cpf\lib\Flux\Template.php(337): include('G:\wamp\www\cpf...')
[2012-08-22 13:43:14] (PDOException) **TRACE** #7 G:\wamp\www\cpf\lib\Flux\Dispatcher.php(168): Flux_Template->render()
[2012-08-22 13:43:14] (PDOException) **TRACE** #8 G:\wamp\www\cpf\index.php(177): Flux_Dispatcher->dispatch(Array)
[2012-08-22 13:43:14] (PDOException) **TRACE** #9 {main}
