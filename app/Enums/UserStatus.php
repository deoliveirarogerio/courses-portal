<?php 

namespace App\Enums;

enum UserStatus: int
{
    case Inativo = 0;
    case Ativo = 1;
}

enum UserType: string
{
    case Admin = 'admin';
    case Aluno = 'aluno';
}