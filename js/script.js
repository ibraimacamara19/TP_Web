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