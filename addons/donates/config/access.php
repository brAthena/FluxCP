<?php
/* 
 [=======================================================]
 [===========                                 ===========]
 [          =   +-+-+-+-+-+-+ +-+-+-+-+-+-+   =          ]
 [          =   |L|i|l|i|u|m| |S|a|n|c|t|a|   =          ]
 [          =   +-+-+-+-+-+-+ +-+-+-+-+-+-+   =          ]
 [          =         +-+-+-+-+-+-+-+         =          ]
 [          =         |S|c|r|i|p|t|s|         =          ]
 [          =         +-+-+-+-+-+-+-+         =          ]
 [===========                                 ===========]
 [=======================================================]
 [      Integração API PagSeguro Versão atual 2.0        ]
 [=======================================================]
 [                      Changelog:                       ]
 [1.0 Addon Criado.                                      ]
 [1.2 Correção em erro de português e rate.              ]
 [1.4 Inseridas novas configurações.                     ]
 [1.6 Corrigido erro com valores.                        ]
 [1.8 Compatibilidade com Hercules adicionada.           ]
 [2.0 Addon totalmente reformulado, diversos erros       ]
 [    corrigidos e novas funções adicionadas.            ]
 [-------------------------------------------------------]
 [     N?O REDISTRIBUA MEU TRABALHO SEM AUTORIZAÇÃO      ]
 [=======================================================]
 [                       Suporte:                        ]
 [                                                       ]
 [ Qualquer erro encontrado pode ser reportado a mim em  ]
 [ meu email pessoal inu-kai@limao.com.br ou diretamente ]
 [ no tópico de download.                                ]
 [=======================================================]
 [ http://www.brathena.org/forum/index.php?showuser=124  ]
 [=======================================================]
*/

return array(
	'modules' => array(
		'doa' => array(
            'index' 	   => AccountLevel::NORMAL,
            'history'	   => AccountLevel::NORMAL,
			'return'       => AccountLevel::NORMAL,
			'notification' => AccountLevel::ANYONE,
			'process'      => AccountLevel::NORMAL,
		),
	),
	
	'modules' => array(
		'cplog' => array(
            'donatelog' 	  => AccountLevel::ADMIN,
            'donateview' 	  => AccountLevel::ADMIN,
			'donatestatistic' => AccountLevel::ADMIN,
			'sobre' 	      => AccountLevel::ADMIN,
		),
	),
)
?>