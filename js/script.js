document.addEventListener("DOMContentLoaded", function () {
    const formularioAluno = document.querySelector(".formulario-aluno");
    const mensagemAluno = document.getElementById("mensagemAluno");

    if (formularioAluno) {
        formularioAluno.addEventListener("submit", function (evento) {
            evento.preventDefault();

            mensagemAluno.textContent = "Validação efetuada com sucesso. O aluno será guardado quando ligarmos o PHP à base de dados.";
        });
    }
});
const formularioProfessor = document.querySelector(".formulario-professor");
const mensagemProfessor = document.getElementById("mensagemProfessor");

if (formularioProfessor) {
    formularioProfessor.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemProfessor.textContent = "Validação efetuada com sucesso. O professor será guardado quando ligarmos o PHP à base de dados.";
    });
}
const formularioTurma = document.querySelector(".formulario-turma");
const mensagemTurma = document.getElementById("mensagemTurma");

if (formularioTurma) {
    formularioTurma.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemTurma.textContent = "Validação efetuada com sucesso. A turma será guardada quando ligarmos o PHP à base de dados.";
    });
}
const formularioDisciplina = document.querySelector(".formulario-disciplina");
const mensagemDisciplina = document.getElementById("mensagemDisciplina");

if (formularioDisciplina) {
    formularioDisciplina.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemDisciplina.textContent = "Validação efetuada com sucesso. A disciplina será guardada quando ligarmos o PHP à base de dados.";
    });
}
const formularioNota = document.querySelector(".formulario-nota");
const mensagemNota = document.getElementById("mensagemNota");

if (formularioNota) {
    formularioNota.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemNota.textContent = "Validação efetuada com sucesso. A nota será guardada quando ligarmos o PHP à base de dados.";
    });
}
const formularioPagamento = document.querySelector(".formulario-pagamento");
const mensagemPagamento = document.getElementById("mensagemPagamento");

if (formularioPagamento) {
    formularioPagamento.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemPagamento.textContent = "Validação efetuada com sucesso. O pagamento será guardado quando ligarmos o PHP à base de dados.";
    });
}
const formularioRelatorio = document.querySelector(".formulario-relatorio");
const mensagemRelatorio = document.getElementById("mensagemRelatorio");

if (formularioRelatorio) {
    formularioRelatorio.addEventListener("submit", function (evento) {
        evento.preventDefault();

        mensagemRelatorio.textContent = "Relatório gerado com sucesso. Os dados reais serão apresentados quando ligarmos o PHP à base de dados.";
    });
}