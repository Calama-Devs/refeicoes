<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/teste', 'Home::teste');

$routes->group('sys', function ($routes) {
    //==============================================================
    // Rotas de Cursos
    //==============================================================
    $routes->group('cursos', static function ($routes) {
        $routes->get('', 'CursoController::index');
        $routes->post('criar', 'CursoController::store');
        $routes->post('atualizar', 'CursoController::update');
        $routes->post('deletar', 'CursoController::delete');
    });

    //==============================================================
    // Rotas de Turmas
    //==============================================================
    $routes->group('turmas', static function ($routes) {
        $routes->get('', 'TurmaController::index');
        $routes->post('criar', 'TurmaController::store');
        $routes->post('atualizar', 'TurmaController::update');
        $routes->post('deletar', 'TurmaController::delete');
    });

    //==============================================================
    // Rotas de Controle de Refeições
    //==============================================================
    $routes->group('controle-refeicoes', static function ($routes) {
        $routes->get('', 'ControleRefeicoesController::index');
        $routes->post('salvar', 'ControleRefeicoesController::salvar');
        $routes->post('atualizar', 'ControleRefeicoesController::atualizar');
        $routes->post('deletar', 'ControleRefeicoesController::deletar');
    });

    //==============================================================
    // Rotas de Alunos
    //==============================================================
    $routes->group('alunos', static function ($routes) {
        $routes->get('', 'AlunoController::index');
        $routes->post('criar', 'AlunoController::criar');
        $routes->get('editar/(:num)', 'AlunoController::edit/$1');
        $routes->put('atualizar/(:num)', 'AlunoController::update/$1');
        $routes->delete('deletar/(:num)', 'AlunoController::delete/$1');
    });

    //==============================================================
    // Rotas de Usuários
    //==============================================================
    $routes->group('usuarios', static function ($routes) {
        $routes->get('', 'UsuarioController::index');
        $routes->post('criar', 'UsuarioController::store');
        $routes->put('atualizar/(:num)', 'UsuarioController::update/$1');
        $routes->delete('deletar/(:num)', 'UsuarioController::delete/$1');
    });

    //==============================================================
    // Rotas de Agendamento
    //==============================================================
    $routes->group('agendamento', static function ($routes) {
        $routes->post('admin/gravar', 'AgendamentoController::gravarPorAdmin');
        $routes->post('aluno/confirmar', 'AgendamentoController::confirmarPorAluno');
        $routes->post('solicitante/solicitar', 'AgendamentoController::solicitarExcecao');
        $routes->put('admin/aprovar/(:num)', 'AgendamentoController::aprovarSolicitacao/$1');
    });

    //==============================================================
    // Rotas do Restaurante
    //==============================================================
    $routes->group('restaurante', static function ($routes) {
        $routes->post('registrar-servida', 'RefeicaoController::registrarServida');
    });

    //==============================================================
    // Rotas de Relatórios
    //==============================================================
    $routes->group('relatorios', static function ($routes) {
        $routes->get('', 'RelatorioController::index');
        $routes->get('previstos', 'RelatorioController::refeicoesPrevistas');
        $routes->get('servidos', 'RelatorioController::refeicoesServidas');
        $routes->get('nao-servidos', 'RelatorioController::refeicoesNaoServidas');
        $routes->get('confirmados', 'RelatorioController::confirmados');
    });
}); // <--- Esta chave de fechamento estava faltando