<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/conexao.php';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/menu.php';
?>

<main class="conteudo">

    <section class="hero">
        <div class="hero-texto">
            <h2>Sistema de Gestão Escolar para Instituições de Ensino na Guiné-Bissau</h2>
            <p>
                Plataforma Web desenvolvida para apoiar a gestão de alunos, professores,
                turmas, disciplinas, notas, pagamentos e relatórios administrativos.
            </p>
            <a href="alunos.php" class="botao">Começar Gestão</a>
        </div>
    </section>

    <section class="cards">
        <article class="card">
            <h3>Alunos</h3>
            <p>Registo, consulta, edição e organização dos alunos por turma.</p>
        </article>

        <article class="card">
            <h3>Professores</h3>
            <p>Gestão dos professores e associação às disciplinas lecionadas.</p>
        </article>

        <article class="card">
            <h3>Notas</h3>
            <p>Lançamento e consulta de notas por disciplina, turma e período.</p>
        </article>

        <article class="card">
            <h3>Pagamentos</h3>
            <p>Controlo de propinas, matrículas e outros pagamentos escolares.</p>
        </article>
    </section>

</main>

<?php include 'includes/footer.php'; ?>