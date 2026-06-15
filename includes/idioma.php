<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idiomas_permitidos = ["pt", "en"];

if (isset($_GET["lang"]) && in_array($_GET["lang"], $idiomas_permitidos)) {
    $_SESSION["lang"] = $_GET["lang"];
}

$idioma_atual = isset($_SESSION["lang"]) ? $_SESSION["lang"] : "pt";

$traducoes = [
    "pt" => [
        "nome_sistema" => "Sistema de Gestão Escolar GB",
        "subtitulo_sistema" => "Gestão escolar adaptada ao contexto da Guiné-Bissau",

        "menu_inicio" => "Início",
        "menu_alunos" => "Alunos",
        "menu_professores" => "Professores",
        "menu_turmas" => "Turmas",
        "menu_disciplinas" => "Disciplinas",
        "menu_notas" => "Notas",
        "menu_pagamentos" => "Pagamentos",
        "menu_relatorios" => "Relatórios",
        "menu_contacto" => "Contacto",

        "idioma" => "Idioma",
        "portugues" => "Português",
        "ingles" => "Inglês",

        "bem_vindo" => "Bem-vindo ao Sistema de Gestão Escolar GB",
        "descricao_inicio" => "Plataforma web para apoiar a gestão de alunos, professores, turmas, disciplinas, notas, pagamentos e relatórios escolares.",

        "gestao_alunos" => "Gestão de Alunos",
        "gestao_professores" => "Gestão de Professores",
        "gestao_turmas" => "Gestão de Turmas",
        "gestao_disciplinas" => "Gestão de Disciplinas",
        "gestao_notas" => "Gestão de Notas",
        "gestao_pagamentos" => "Gestão de Pagamentos",
        "relatorios_administrativos" => "Relatórios Administrativos",

        "botao_guardar" => "Guardar",
        "botao_atualizar" => "Atualizar",
        "botao_eliminar" => "Eliminar",
        "botao_editar" => "Editar",
        "botao_limpar" => "Limpar",
        "botao_imprimir" => "Imprimir",
        "botao_gerar_pdf" => "Gerar PDF",

        "nome" => "Nome",
        "email" => "Email",
        "contacto" => "Contacto",
        "turma" => "Turma",
        "disciplina" => "Disciplina",
        "professor" => "Professor",
        "nota" => "Nota",
        "estado" => "Estado",
        "observacao" => "Observação",
        "valor" => "Valor",
        "data" => "Data",

        "republica_gb" => "REPÚBLICA DA GUINÉ-BISSAU",
        "ministerio_educacao" => "Ministério da Educação Nacional"
    ],

    "en" => [
        "nome_sistema" => "GB School Management System",
        "subtitulo_sistema" => "School management adapted to the context of Guinea-Bissau",

        "menu_inicio" => "Home",
        "menu_alunos" => "Students",
        "menu_professores" => "Teachers",
        "menu_turmas" => "Classes",
        "menu_disciplinas" => "Subjects",
        "menu_notas" => "Grades",
        "menu_pagamentos" => "Payments",
        "menu_relatorios" => "Reports",
        "menu_contacto" => "Contact",

        "idioma" => "Language",
        "portugues" => "Portuguese",
        "ingles" => "English",

        "bem_vindo" => "Welcome to the GB School Management System",
        "descricao_inicio" => "Web platform to support the management of students, teachers, classes, subjects, grades, payments and school reports.",

        "gestao_alunos" => "Student Management",
        "gestao_professores" => "Teacher Management",
        "gestao_turmas" => "Class Management",
        "gestao_disciplinas" => "Subject Management",
        "gestao_notas" => "Grade Management",
        "gestao_pagamentos" => "Payment Management",
        "relatorios_administrativos" => "Administrative Reports",

        "botao_guardar" => "Save",
        "botao_atualizar" => "Update",
        "botao_eliminar" => "Delete",
        "botao_editar" => "Edit",
        "botao_limpar" => "Clear",
        "botao_imprimir" => "Print",
        "botao_gerar_pdf" => "Generate PDF",

        "nome" => "Name",
        "email" => "Email",
        "contacto" => "Contact",
        "turma" => "Class",
        "disciplina" => "Subject",
        "professor" => "Teacher",
        "nota" => "Grade",
        "estado" => "Status",
        "observacao" => "Observation",
        "valor" => "Amount",
        "data" => "Date",

        "republica_gb" => "REPUBLIC OF GUINEA-BISSAU",
        "ministerio_educacao" => "Ministry of National Education"
    ]
];

function t($chave) {
    global $traducoes, $idioma_atual;

    if (isset($traducoes[$idioma_atual][$chave])) {
        return $traducoes[$idioma_atual][$chave];
    }

    return $chave;
}

function link_idioma($codigo_idioma) {
    $parametros = $_GET;
    $parametros["lang"] = $codigo_idioma;

    return htmlspecialchars($_SERVER["PHP_SELF"] . "?" . http_build_query($parametros));
}
?>