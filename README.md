
<p align="center">
    <img width="300" src="./public/logo.webp" alt="Logo KLB Revenda">
</p>
<h1>Sistema de gerenciamento de produtos e pedidos para uma revenda</h1>

<p>Sistema desenvolvido como trabalho de conclusão do curso de Pós Graduação Full-Stack da PUC-RS Online</p>

<br>
<h2>Para rodar o sistema</h2>

<h3>Clonar o repositório</h3>
Por meio do git pode ser clonado via:

<code>git clone https://github.com/kabratz/klbrevenda.git</code>
<hr>
<h3>Requisitos</h3>
Ter PHP, composer e npm instalados na máquina.

<hr>
<h3>Setups Iniciais</h3>
<h4>Copiar env</h4>

<code>cp .env.example .env</code>

<p>
    <strong>
        Alterar os dados do banco para seu banco local
    </strong>
</p>

<h4>Instalar dependências</h4>
<code>npm install</code>
<hr>
<h3>Rodar os comandos que sobem o servidor</h3>
<p>
    Em uma aba do terminal:
    <br>
    <code>php artisan serve</code>
    <br>
    Acessar link gerado pelo comando acima (default http://127.0.0.1:8000/)
</p>

<p>
    Em outra aba (manter a anterior aberta):
    <br>
    <code>npm run dev</code>
</p>

