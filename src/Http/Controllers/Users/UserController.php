<?php

namespace MiniRest\Http\Controllers\Users;
use MiniRest\Actions\User\UserCreateAction;
use MiniRest\Actions\User\UserFlgStatusAction;
use MiniRest\Actions\User\UserUpdateAction;
use MiniRest\DTO\AddressCreateDTO;
use MiniRest\DTO\User\UserCreateDTO;
use MiniRest\DTO\User\UserFlgStatusDTO;
use MiniRest\Helpers\StatusCode\StatusCode;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Controllers\Controller;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Models\User;
use MiniRest\Repositories\UserRepository;
use MiniRest\Repositories\AvatarRepository;

class UserController extends Controller
{

    public function index()
    {
        Response::json(['user' => $this->paginate(User::query())]);
    }

    public function me(Request $request)
    {
        $userId = Auth::id($request);
        $user = (new UserRepository())->me($userId);
        $photo = (new AvatarRepository())->getUserAvatar($userId);
        $photoEvento = asset("avatar/" . $photo);
        if ($photo == null) {
            $photo = null;
            
            $data [] = [
                'user' => $user['user'],
                'localidade' => $user['localidade'],
                'photo' => $photo,
            ];
            Response::json(['userinfos' => $data]);
        }else{
            $data [] = [
                'user' => $user['user'],
                'localidade' => $user['localidade'],
                'photo' => $photoEvento,
            ];
            Response::json(['userinfos' => $data]);
        }
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {


        $validation = $request->rules([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'contactno' => 'required|string',
            'password' => 'required|password:min_length=8',
            'endereco' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'idade' => 'required',
            
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }

        

        $userDTO = new UserCreateDTO($request);
        (new UserCreateAction())->execute($userDTO);

        Response::json([
            'message'=>'Usuário criado com sucesso!',
        ], StatusCode::CREATED);

    }

    public function update(Request $request)
    {
        $userId = Auth::id($request);
        $validation = $request->rules([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'contactno' => 'required|string',
            'password' => 'required|password:min_length=8',
            'endereco' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'idade' => 'required',
            
        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }


        $userDTO = new UserCreateDTO($request);

        (new UserUpdateAction())->execute($userId, $userDTO);

        Response::json([
            'message'=>'Usuário atualizado com sucesso',
        ]);

    }

    // public function removeUser(Request $request)
    // {
    //     $validation = $request->rules([
    //         'flg' => 'required'
    //     ])->validate();

    //     if (!$validation) {
    //         $request->errors();
    //         return;
    //     }

    //     $userId = Auth::id($request);

    //     $userDTO = new UserFlgStatusDTO($request);



    //     Response::json([
    //         'message'=>'Usuário "flegado" com sucesso',
    //     ]);

    // }
}