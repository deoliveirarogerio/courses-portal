<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'status' => 'required|integer',
            'type' => 'required|string',
        ]);

        User::create($validated);
        
        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8',
            'status' => 'required',
            'type' => 'required',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->status = $request->input('status');
        $user->type = $request->input('type');
        $user->save();

        return response()->json($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}

