<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * O nome e a assinatura do comando (como ele será executado no terminal).
     *
     * @var string
     */
    protected $signature = 'user:create 
                            {--n= : Nome do usuário} 
                            {--e= : Email do usuário} 
                            {--p= : Senha do usuário}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Cria um novo usuário na tabela users';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        // Recebe os parâmetros do comando
        $name = $this->option('n') ?? '';
        $email = $this->option('e') ?? '';
        $password = $this->option('p') ?? '';

        
        while (empty($name) || strlen($name) < 3) {
            $name = $this->ask('Digite o nome do usuário');
        }
        
        while (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->ask('Digite o email do usuário');
        }
        
        while(empty($password) || strlen($password) < 8) {
            $password = $this->secret('Digite a senha do usuário');
        }

        // Verifica se o email já está em uso
        if (User::where('email', $email)->exists()) {
            $this->error('Um usuário com este email já existe.');
            return 1;
        }

        // Cria o usuário
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Mostra uma mensagem de sucesso
        $this->info("Usuário criado com sucesso!");
        $this->info("ID: {$user->id}");
        $this->info("Nome: {$user->name}");
        $this->info("Email: {$user->email}");

        return 0;
    }
}
