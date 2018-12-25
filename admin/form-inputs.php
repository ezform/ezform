<?php

include(__DIR__ . '/../config.php');
include(INCLUDE_PATH . '/auth.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'add':
        add();
        break;
    case 'show_edit':
        show_edit();
        break;
    case 'edit':
        edit();
        break;
    case 'delete':
        delete();
        break;
    default:
        index();
}

function index()
{
    $data = [];
    $data['page_title'] = __('Form Inputs');
    $data['active_menu'] = 'form-inputs';

    $data['form_inputs'] = R::findAll('form_inputs');

    include(ADMIN_PATH . '/templates/form-inputs.php');
}

function add()
{
    $alerts = [];
    if (!$_POST['title']) {
        array_push($alerts, [
            'type'    => 'danger',
            'message' => __('Title is required')
        ]);

        $_SESSION['alerts'] = $alerts;
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    $formInput = R::xdispense('form_inputs');
    $formInput->title = $_POST['title'];
    $formInput->required = $_POST['required'] ? 1 : 0;
    R::store($formInput);

    array_push($alerts, [
        'type'    => 'success',
        'message' => __('Added')
    ]);
    $_SESSION['alerts'] = $alerts;
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function show_edit()
{
    if (isset($_GET['id'])) {
        $formInput = R::load('form_inputs', $_GET['id']);
        if ($formInput) {
            $data = [];
            $data['page_title'] = __('Edit');
            $data['active_menu'] = 'form-inputs';
            $data['form_input'] = $formInput;

            include(ADMIN_PATH . '/templates/form-inputs-edit.php');
        }
    }
}

function edit()
{
    $alerts = [];
    if (isset($_GET['id'])) {
        $formInput = R::load('form_inputs', $_GET['id']);
        if ($formInput) {
            if (!$_POST['title']) {
                array_push($alerts, [
                    'type'    => 'danger',
                    'message' => __('Title is required')
                ]);

                $_SESSION['alerts'] = $alerts;
                header('location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        $formInput->title = $_POST['title'];
        $formInput->required = $_POST['required'] ? 1 : 0;
        R::store($formInput);

        array_push($alerts, [
            'type'    => 'success',
            'message' => __('Changes saved')
        ]);
        $_SESSION['alerts'] = $alerts;
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

function delete()
{
    if (isset($_GET['id'])) {
        $formInput = R::load('form_inputs', $_GET['id']);
        if ($formInput) {
            R::trash($formInput);

            array_push($alerts, [
                'type'    => 'success',
                'message' => __('Deleted')
            ]);
            $_SESSION['alerts'] = $alerts;
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}

$_SESSION['alerts'] = null;