<?php 
/**
* 
*/
class funcionalidadeConst
{
	const RESET_TRUE 	= 'S';
	const RESET_FALSE 	= 'N';
	const RESET_AGENDA_TRUE 	= '1';
	const RESET_AGENDA_FALSE 	= '0';
	const RESET_PORTAL_TRUE 	= 'S';
	const RESET_PORTAL_FALSE 	= 'N';
	const RESET_FOLHA_TRUE 	    = 'S';
	const RESET_FOLHA_FALSE 	= 'N';
	const LIBERA_TRUE 	= 'S';
	const LIBERA_FALSE 	= 'N';
	
	const ATIVO 	= 'A';
	const INATIVO 	= 'I';

	const SENHA_PADRAO 	= 'ADMIN123';
	const SENHA_AGENDA 	= 'teste123';

	const perfil_usuario	 			= 1;
	const perfil_fiscal 				= 2;
	const perfil_projeto 				= 3;
	const perfil_portal 				= 4;
	const perfil_folha  				= 5;
	
	const AGENDA						= 1;
	const APONTAMENTOHORAS				= 2;
	const APONTAMENTOAGENDA				= 3;
	const PORTALFORNECEDOR				= 4;
	const FOLHAPAGTO				    = 5;

	const PERFIL_ADMIN = 1;	
	const PERFIL_BPO = 2;
	const PERFIL_PROJETOS = 3;
	const PERFIL_BPO_PROJETOS = 4;
	const PERFIL_BPO_PORTAL = 5;
	const PERFIL_BPO_PROJETOS_PORTAL = 6;
	const PERFIL_PORTAL = 7;
	const PERFIL_PROJETOS_PORTAL = 8;
	const PERFIL_FOLHA = 9;
	const PERFIL_BPO_PROJETOS_FOLHA = 10;
	const PERFIL_BPO_FOLHA = 11;
	const PERFIL_PROJETOS_FOLHA = 12;

	const LINK_GP = 'http://dev.apontamentohoras/login.php';
	const LINK_TAX = 'http://dev.agenda/login';
	const LINK_PORTAL = 'http://dev.portalfornecedor/login';
	const LINK_FOLHA = 'http://dev.folhapagto/login.php';
}
