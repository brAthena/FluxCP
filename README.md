# FluxCP brAthena

## Instalação
Para instalar o FluxCP corretamente, basta acessar os arquivos [application.php](https://github.com/brAthena/FluxCP/blob/master/config/application.php) e [servers.php](https://github.com/brAthena/FluxCP/blob/master/config/servers.php) na pasta config e configurar ambos com corretamente, alterando as informações de url, senha de instalação e dados do servidor.

## Vote Por Pontos
Esse sistema foi criado pelo usuário JayPee do rAthena em 2012, e desde então o sistema está obsoleto e não funciona corretamente, porém efetuei as correções e incorporei ele ao nosso painel de controle, então poderão fazer uso do mesmo sem nenhum problema, se ainda assim quiserem conferir a versão original, segue o link: [Add On Vote for Points 1.2](https://rathena.org/board/topic/60640-fluxcp-addon-vote-for-points/)

## Pagseguro
O sistema do pagseguro incorporado ao nosso painel de controle foi criado pelo usuário Lilium Sancta, então caso queiram entender melhor como o sistema funciona, assim como aprender a configurar o mesmo corretamente, acesse e façam download do arquivo do usuário diretamente no fórum: [Addon PagSeguro FluxCP](http://forum.brathena.org/index.php/topic/22210-addon-pagseguro-fluxcp/)

## Paypal
Para configurar o paypal é necessário acessar o arquivo [application.php](https://github.com/brAthena/FluxCP/blob/master/config/application.php) na pasta config e altera a linha 98 e colocar o e-mail de sua conta do Paypal. Após fazer isso você deverá acessar sua conta no Paypal e configurar o IPN/NIP que é o sistema de notificação instântanea de pagamentos, você pode obter ajuda com isso diretamente no site do Paypal, nós não daremos suporte a esse tipo de configuração, mas fica aqui o link que poderá te ajudar:  [NIP](https://www.paypal.com/br/cgi-bin/webscr?cmd=p/acc/ipn-info-outside)

Caso você queira utilizar a Loja de Itens do Painel de Controle, deverá acessar o [application.php](https://github.com/brAthena/FluxCP/blob/master/config/application.php) na pasta config, e descomentar a linha 221.

Caso não queira fazer uso da Loja e queira que o Retorno de Dados seja mais dinâmico entregando os créditos direto no jogo para o usuário, basta baixar nosso script que faz conversão dos créditos para cashpoints em: [Resource Paypal](http://forum.brathena.org/index.php/files/file/3230-resources-fluxcp-bra/)

Att, Tidus.
Equipe brAthena.

Contribuidores / Créditos: Matthew Harris, Nikunj Mehta, Xantara.
