<?php

namespace HackbartPR\Utils;

class Message
{
    const TITLE_FAIL = 'Título não é valido.';
    const URL_FAIL = 'URL não é válida.';
    const FORM_FAIL = 'Erro ao enviar o formulário.';
    const REGISTER_FAIL = 'Erro ao Cadastrar o Vídeo.';
    const REGISTER_SUCCESS = 'Video Cadastrado com Sucesso!';
    const UPDATE_FAIL = 'Erro ao Atualizar o Vídeo.';
    const UPDATE_SUCCESS = 'Video atualizado com sucesso!';
    const REMOVE_FAIL = 'Livro não pode ser excluído, tente novamente!';
    const REMOVE_SUCCESS = 'Video excluído com sucesso!';
    const NOT_FOUND = 'Video não informado!';
    const EMAIL_INVALID = 'E-mail não é válido.';    
    const LOGIN_FAIL = 'Usuário não encontrado.';
    const LOGIN_SUCCESS = 'Bem Vindo!';
    const IMAGE_NOT_SAVED = 'Não foi possível salvar a imagem desejada.';

    const STATUS_MAP = [
        self::REGISTER_SUCCESS => true,
        self::UPDATE_SUCCESS => true,
        self::REMOVE_SUCCESS => true,
        self::LOGIN_SUCCESS => true,
    ];

    public static function create(string $constant, string $location = null): void
    {   
        $_SESSION['save']['status'] = self::STATUS_MAP[$constant] ?? false;
        $_SESSION['save']['message'] = $constant;
        
        if ($location) {
            header("Location: $location");    
            exit();    
        }

        header('Location: /');    
        exit();
    }

    public static function show(): void
    {
        if (isset($_SESSION['save'])) {
            if ($_SESSION['save']['status']) { ?>
                <div class='message success'>
                    <?= $_SESSION['save']['message']; ?>
                </div> <?php            
            } else { ?>
                <div class='message error'>
                    <?= $_SESSION['save']['message']; ?>
                </div> <?php
            }
            unset($_SESSION['save']);
        }
    }
}