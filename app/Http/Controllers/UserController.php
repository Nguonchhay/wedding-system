<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Flash;

class UserController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;



    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->activeMenu = ['active' => 'user', 'subMenu' => ''];
        $this->viewPath = 'users.';
        $this->routePath = 'users.';
    }

    /**
     * @return Response
     */
    public function index(Request $request) {
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('user')) {
            return redirect(route('users.show', ['id' => $authUser->id]));
        }

        $users = $this->userRepository->all();
        if ($authUser->hasRole('admin')) {
            $users = $this->userRepository->findWhere([
                'created_by' => $authUser->id
            ]);
            $users[] = $authUser;
        }

        $selectedRole = trim($request->get('role', ''));
        if ($selectedRole !== '') {
            if ($authUser->hasRole('super_admin')) {
                $users = $this->userRepository->findWhere([
                    'role' => $selectedRole
                ]);
            } else {
                $users = $this->userRepository->findWhere([
                    'created_by' => $authUser->id,
                    'role' => $selectedRole
                ]);
            }

            if ($authUser->hasRole('admin') && $selectedRole === 'admin') {
                $users[] = $authUser;
            }
        }

        $userRoles = $this->getUserRoles($authUser);
        array_unshift($userRoles, ['' => 'Select user role']);

        return $this->assignToView('User List', 'index', [
            'userRoles' => $userRoles,
            'selectedRole' => $selectedRole,
            'users' => $users
        ]);
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function show($id) {
        $user = $this->checkExistUser($id);
        return $this->assignToView('User detail', 'show', [
            'user' => $user
        ]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        return $this->assignToView('New user', 'create', [
            'userRoles' => $this->getUserRoles(Auth::user())
        ]);
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $input = $request->all();

        /** @var User|null $queryUser */
        $queryUser = $this->userRepository->findWhere(['email' => $input['email']])->first();
        if (! empty($queryUser)) {
            Flash::success('Email already exists in the system.');
            return $this->redirectToIndex();
        }

        if ($input['password'] !== $input['confirm_password']) {
            Flash::success('Password and confirm password do not match.');
            return $this->redirectTo('create');
        }

        unset($input['confirm_password']);
        $input['password'] = bcrypt($input['password']);
        $input['created_by'] = Auth::user()->id;
        $user = $this->userRepository->create($input);
        Flash::success('User was saved successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->checkExistUser($id);
        return $this->assignToView('Edit user', 'edit', [
            'user' => $user,
            'userRoles' => $this->getUserRoles(Auth::user())
        ]);
    }

    /**
     * @param string $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $input = $request->all();
        $user = $this->checkExistUser($id);
        $input['password'] = $request->get('password', null);
        $input['confirm_password'] = $request->get('confirm_password', null);

        if ($input['password'] !== null && $input['confirm_password'] !== null) {
            if ($input['password'] !== $input['confirm_password']) {
                Flash::success('Password and confirm password do not match.');
                return $this->redirectToIndex();
            }
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        unset($input['email']);
        unset($input['confirm_password']);
        $user = $this->userRepository->update($input, $user->id);
        Flash::success('User was updated successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->checkExistUser($id);
        $superAdmin = $this->userRepository->findWhere(['role' => 'super_admin'])->first();
        if ($superAdmin && $superAdmin->id === $id) {
            Flash::success('System needs at least one Super admin. You cannot delete this user.');
            return $this->redirectToIndex();
        }

        $this->userRepository->delete($user->id);

        /** @var User $authUser */
        $authUser = Auth::user();
        if ($user->id === $authUser->id) {
            Auth::logout();
            return redirect('/');
        }

        Flash::success('User deleted successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     * @return User|null
     */
    private function checkExistUser($id)
    {
        /** @var User|null $guest */
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            return $this->redirectToIndex();
        }
        return $user;
    }

    /**
     * @param User $user
     * @return array
     */
    private function getUserRoles($user)
    {
        /** @var array $roles */
        $roles = config('settings.roles');
        if ($user->hasRole('user')) {
            $roles = ['user' => 'User'];
        } elseif (!$user->hasRole('super_admin')) {
            unset($roles['super_admin']);
        }

        return $roles;
    }
}
