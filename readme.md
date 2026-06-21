# Carona Solidária 🚗

Sistema web desenvolvido para a comunidade acadêmica do SENAI, focado em facilitar e otimizar o compartilhamento de caronas de forma segura, garantindo mobilidade para os alunos.

## ⚙️ Funcionalidades Principais

O sistema contempla as operações fundamentais (CRUD) e as lógicas de negócio abaixo:
* **Gestão de Usuários:** Cadastro e autenticação restrita para alunos ativos e funcionários (Motoristas e Passageiros).
* **Gestão de Caronas:** Motoristas podem registrar veículos, cadastrar rotas, horários e vagas disponíveis.
* **Busca e Reserva:** Passageiros podem buscar trajetos compatíveis e solicitar reservas.
* **Sistema de Avaliação:** Avaliação mútua entre passageiros e motoristas após a conclusão do trajeto.

## 🚀 Tecnologias e Arquitetura

O projeto foi construído separando as camadas lógicas através do padrão arquitetural **MVC** (Model-View-Controller) aliado ao padrão **DAO** (Data Access Object) para a persistência de dados.

* **Front-end:** HTML5, CSS3 e JavaScript.
* **Back-end:** PHP.
* **Banco de Dados:** MySQL.

## ⚙️ Como executar o projeto localmente

Para testar a aplicação na sua máquina, siga os passos abaixo:

1. Certifique-se de ter um servidor local instalado (como o **XAMPP**) e inicie os serviços **Apache** e **MySQL**.
2. Faça o clone ou baixe este repositório e mova a pasta do projeto para dentro do diretório público do servidor (ex: `C:\xampp\htdocs\`).
3. Acesse o gerenciador do banco de dados (ex: `http://localhost/phpmyadmin`) e crie um banco de dados vazio chamado `banco.local`.
4. Importe o arquivo `projeto_aplicado.sql` (localizado na pasta `app/BD/`) para dentro deste novo banco.
5. No navegador, acesse o endereço da aplicação: `http://localhost/carona-solidaria/` (substitua o final pelo nome exato da sua pasta).

## 👥 Equipe Desenvolvedora (Grupo 13)

* Fabiano Carcuchinski Haag
* Marcio Figueredo
* Sidnei Avelino da Silva Junior